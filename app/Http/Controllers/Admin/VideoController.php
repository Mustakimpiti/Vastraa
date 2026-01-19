<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        try {
            // Increase time limit for large uploads
            set_time_limit(300); // 5 minutes
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'video_file' => 'required|file|mimes:mp4,mov,avi,wmv|max:204800', // 200MB max
                'is_active' => 'nullable|boolean',
                'sort_order' => 'nullable|integer|min:0'
            ]);

            // Set default values
            $validated['is_active'] = $request->has('is_active') ? 1 : 0;
            $validated['sort_order'] = $validated['sort_order'] ?? 0;

            // Ensure directory exists
            $this->ensureDirectoryExists();

            // Handle video upload
            if ($request->hasFile('video_file')) {
                $video = $request->file('video_file');
                
                // Check if file uploaded successfully
                if (!$video->isValid()) {
                    return back()->withErrors(['video_file' => 'Video upload failed. Please try again.']);
                }
                
                // Get original extension and force to lowercase mp4
                $extension = strtolower($video->getClientOriginalExtension());
                
                // Generate unique filename with proper extension
                $filename = time() . '_' . uniqid() . '.' . $extension;
                
                // Move file to destination
                $video->move(public_path('uploads/videos'), $filename);
                
                // Set proper permissions
                chmod(public_path('uploads/videos/' . $filename), 0644);
                
                $validated['video_path'] = 'uploads/videos/' . $filename;
            }

            Video::create($validated);

            return redirect()->route('admin.videos.index')
                ->with('success', 'Video uploaded successfully!');
                
        } catch (\Exception $e) {
            Log::error('Video upload error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to upload video: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        try {
            // Increase time limit for large uploads
            set_time_limit(300); // 5 minutes
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'video_file' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:204800', // 200MB max
                'is_active' => 'nullable|boolean',
                'sort_order' => 'nullable|integer|min:0'
            ]);

            // Set default values
            $validated['is_active'] = $request->has('is_active') ? 1 : 0;
            $validated['sort_order'] = $validated['sort_order'] ?? $video->sort_order;

            // Ensure directory exists
            $this->ensureDirectoryExists();

            // Handle new video upload
            if ($request->hasFile('video_file')) {
                $videoFile = $request->file('video_file');
                
                // Check if file uploaded successfully
                if (!$videoFile->isValid()) {
                    return back()->withErrors(['video_file' => 'Video upload failed. Please try again.']);
                }
                
                // Delete old video
                if ($video->video_path && file_exists(public_path($video->video_path))) {
                    unlink(public_path($video->video_path));
                }
                
                // Generate unique filename
                $filename = time() . '_' . uniqid() . '.' . $videoFile->getClientOriginalExtension();
                
                // Move file to destination
                $videoFile->move(public_path('uploads/videos'), $filename);
                
                $validated['video_path'] = 'uploads/videos/' . $filename;
            }

            $video->update($validated);

            return redirect()->route('admin.videos.index')
                ->with('success', 'Video updated successfully!');
                
        } catch (\Exception $e) {
            Log::error('Video update error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update video: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Video $video)
    {
        try {
            // Delete video file
            if ($video->video_path && file_exists(public_path($video->video_path))) {
                unlink(public_path($video->video_path));
            }

            $video->delete();

            return redirect()->route('admin.videos.index')
                ->with('success', 'Video deleted successfully!');
                
        } catch (\Exception $e) {
            Log::error('Video deletion error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete video: ' . $e->getMessage()]);
        }
    }

    public function toggleActive(Video $video)
    {
        $video->is_active = !$video->is_active;
        $video->save();

        return response()->json([
            'success' => true,
            'is_active' => $video->is_active
        ]);
    }

    private function ensureDirectoryExists()
    {
        $directory = public_path('uploads/videos');
        
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
    }

    // Add this method to VideoController
public function serve($filename)
{
    $path = public_path('uploads/videos/' . $filename);
    
    if (!file_exists($path)) {
        abort(404);
    }
    
    $file = fopen($path, 'rb');
    $size = filesize($path);
    $length = $size;
    $start = 0;
    $end = $size - 1;
    
    header('Content-Type: video/mp4');
    header('Accept-Ranges: bytes');
    
    if (isset($_SERVER['HTTP_RANGE'])) {
        $c_start = $start;
        $c_end = $end;
        
        list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
        if (strpos($range, ',') !== false) {
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            header("Content-Range: bytes $start-$end/$size");
            exit;
        }
        
        if ($range == '-') {
            $c_start = $size - substr($range, 1);
        } else {
            $range = explode('-', $range);
            $c_start = $range[0];
            $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
        }
        
        $c_end = ($c_end > $end) ? $end : $c_end;
        
        if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            header("Content-Range: bytes $start-$end/$size");
            exit;
        }
        
        $start = $c_start;
        $end = $c_end;
        $length = $end - $start + 1;
        
        fseek($file, $start);
        header('HTTP/1.1 206 Partial Content');
    }
    
    header("Content-Range: bytes $start-$end/$size");
    header("Content-Length: $length");
    
    $buffer = 1024 * 8;
    while (!feof($file) && ($p = ftell($file)) <= $end) {
        if ($p + $buffer > $end) {
            $buffer = $end - $p + 1;
        }
        
        set_time_limit(0);
        echo fread($file, $buffer);
        flush();
    }
    
    fclose($file);
    exit;
}
}