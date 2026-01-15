<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'The Art of Draping: 10 Modern Ways to Wear a Saree',
                'excerpt' => 'Discover contemporary draping styles that blend tradition with modern fashion trends. From butterfly drapes to dhoti style, explore new ways to wear your saree.',
                'content' => '<p>The saree has evolved beyond traditional draping methods. Today\'s fashion-forward women are experimenting with innovative styles that showcase their personality while honoring tradition.</p>

<h4>1. The Butterfly Drape</h4>
<p>This contemporary style features pleats that fan out like butterfly wings at the back. Perfect for cocktail parties and modern celebrations.</p>

<h4>2. The Dhoti Style</h4>
<p>Combining the elegance of a saree with the comfort of a dhoti, this style is perfect for those who want freedom of movement without compromising on style.</p>

<h4>3. The Belt Drape</h4>
<p>Add a stylish belt over your saree to create a fusion look that\'s perfect for casual outings or office wear.</p>

<p>Remember, the key to carrying any draping style is confidence. Experiment with different styles to find what works best for your body type and personality.</p>',
                'is_featured' => true,
                'is_published' => true,
                'author_name' => 'Priya Sharma',
                'views' => 245,
            ],
            [
                'title' => 'Saree Care 101: How to Preserve Your Heritage Pieces',
                'excerpt' => 'Learn the best practices for storing and caring for your precious sarees. Essential tips to keep your silk, cotton, and designer sarees looking brand new.',
                'content' => '<p>Your saree collection deserves proper care to maintain its beauty and longevity. Here are expert tips for preserving your treasured pieces.</p>

<h4>Storage Tips</h4>
<p>Always store sarees in a cool, dry place away from direct sunlight. Use muslin or cotton cloth to wrap silk sarees - never plastic!</p>

<h4>Cleaning Guidelines</h4>
<p>Most silk sarees require dry cleaning. For cotton sarees, gentle hand washing in cold water works best. Always read the care label.</p>

<h4>Preventing Damage</h4>
<p>Refold your sarees every few months along different lines to prevent permanent creases. Use neem leaves or lavender sachets to keep insects away.</p>

<blockquote>A well-maintained saree can last for generations and become a cherished family heirloom.</blockquote>',
                'is_featured' => true,
                'is_published' => true,
                'author_name' => 'Ananya Desai',
                'views' => 189,
            ],
            [
                'title' => 'Silk vs Cotton: Choosing the Right Fabric for Every Occasion',
                'excerpt' => 'Confused about which fabric to choose? This comprehensive guide breaks down the pros and cons of different saree fabrics for various occasions.',
                'content' => '<p>Choosing the right saree fabric can make or break your look. Let\'s explore the characteristics of popular saree fabrics.</p>

<h4>Silk Sarees</h4>
<p>Perfect for weddings, festivals, and formal events. Silk sarees are luxurious, rich in texture, and drape beautifully. However, they require careful maintenance.</p>

<h4>Cotton Sarees</h4>
<p>Ideal for daily wear, office, and casual occasions. Cotton is breathable, comfortable, and easy to maintain. Perfect for hot and humid weather.</p>

<h4>Georgette and Chiffon</h4>
<p>These lightweight fabrics are great for parties and evening events. They drape elegantly and are comfortable to wear for long hours.</p>

<p>Consider the occasion, weather, and your comfort when selecting a saree fabric. Each has its unique charm and purpose.</p>',
                'is_featured' => false,
                'is_published' => true,
                'author_name' => 'Meera Kapoor',
                'views' => 156,
            ],
            [
                'title' => 'Wedding Season Special: Top 5 Bridal Saree Trends',
                'excerpt' => 'Planning your wedding wardrobe? Check out the hottest bridal saree trends that are dominating wedding celebrations this season.',
                'content' => '<p>Bridal fashion is constantly evolving. Here are the top trends making waves in bridal sarees this season.</p>

<h4>1. Pastel Perfection</h4>
<p>Soft pastel shades like mint green, powder pink, and lavender are replacing traditional reds for modern brides who want a contemporary look.</p>

<h4>2. Heavy Embellishment</h4>
<p>Intricate zari work, sequins, and stone embellishments are in high demand. The more elaborate, the better!</p>

<h4>3. Pre-Draped Sarees</h4>
<p>For convenience without compromising on style, pre-draped sarees are becoming increasingly popular among brides.</p>

<h4>4. Contemporary Blouse Designs</h4>
<p>Brides are experimenting with crop tops, jacket-style blouses, and backless designs to add a modern twist.</p>

<h4>5. Eco-Friendly Fabrics</h4>
<p>Sustainable fashion is trending, with many brides choosing organic silk and handloom sarees for their special day.</p>',
                'is_featured' => true,
                'is_published' => true,
                'author_name' => 'Riya Patel',
                'views' => 312,
            ],
            [
                'title' => 'The History of Sarees: A Journey Through Time',
                'excerpt' => 'Explore the rich history and cultural significance of the saree. From ancient India to modern fashion runways, discover how this garment has evolved.',
                'content' => '<p>The saree is more than just a garment - it\'s a symbol of Indian culture and heritage that has stood the test of time.</p>

<h4>Ancient Origins</h4>
<p>Evidence of saree-like garments dates back to the Indus Valley Civilization (2800-1800 BCE). Ancient sculptures and texts describe draped garments remarkably similar to modern sarees.</p>

<h4>Regional Variations</h4>
<p>Different regions of India developed their unique weaving techniques and draping styles, giving rise to varieties like Banarasi, Kanjeevaram, Chanderi, and Tant.</p>

<h4>Colonial Influence</h4>
<p>During British rule, the saree evolved to incorporate blouses and petticoats, adapting to Victorian sensibilities while maintaining its essence.</p>

<h4>Modern Evolution</h4>
<p>Today, designers are reimagining the saree for contemporary audiences, proving that this ancient garment remains as relevant as ever.</p>

<blockquote>The saree is not just clothing; it\'s a living tradition that connects us to our roots while allowing us to express our individuality.</blockquote>',
                'is_featured' => false,
                'is_published' => true,
                'author_name' => 'Dr. Kavita Menon',
                'views' => 203,
            ],
            [
                'title' => 'Styling Tips: Accessorizing Your Saree Like a Pro',
                'excerpt' => 'The right accessories can elevate your saree look from ordinary to extraordinary. Learn how to choose jewelry, bags, and footwear that complement your saree.',
                'content' => '<p>Accessories play a crucial role in completing your saree look. Here\'s how to choose the right pieces.</p>

<h4>Jewelry Selection</h4>
<p>For heavy sarees, keep jewelry minimal. For simple sarees, you can go bold with statement pieces. Always consider the neckline of your blouse when choosing necklaces.</p>

<h4>Footwear Matters</h4>
<p>Heels add elegance and help manage the saree length. However, comfortable wedges or flats work great for long events. Match your footwear to your saree\'s formality level.</p>

<h4>The Perfect Bag</h4>
<p>Clutches work best with sarees for formal events. For casual wear, crossbody bags offer convenience without compromising style.</p>

<h4>Hair and Makeup</h4>
<p>Your hairstyle should complement your saree\'s neckline and overall look. Traditional sarees pair well with a bun or braid, while modern drapes look great with loose curls.</p>',
                'is_featured' => false,
                'is_published' => true,
                'author_name' => 'Sanya Malhotra',
                'views' => 178,
            ],
        ];

        foreach ($blogs as $index => $blogData) {
            Blog::create(array_merge($blogData, [
                'published_at' => now()->subDays(rand(1, 30)),
                'meta_title' => $blogData['title'] . ' - Artfauj Blog',
                'meta_description' => $blogData['excerpt'],
                'meta_keywords' => 'saree, fashion, style, traditional wear, indian clothing',
            ]));
        }

        $this->command->info('Blog posts seeded successfully!');
    }
}