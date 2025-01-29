<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Art',
            'description' => 'Unlock your creativity with our diverse art classes. From painting to drawing, sculpture to mixed media, our expert-led workshops cater to all skill levels and interests.',
            'slug' => 'art',
        ]);
        Category::create([
            'name' => 'Baking',
            'description' => 'Indulge your passion for baking with our top-rated classes in [location]. Our expert-led workshops offer hands-on experience and insider tips.',
            'slug' => 'baking',
        ]);
        Category::create([
            'name' => 'Candle Making',
            'description' => 'Join the best candle making classes [location], unleash your imagination, and create personalized candles that illuminate any space. Experience the magic of candle making.',
            'slug' => 'candle-making',
        ]);
        Category::create([
            'name' => 'Cooking',
            'description' => 'Learn all about the world of cooking and discover amazing recipes that will enable you to get creative in the kitchen. Mixing ingredients, flavours and spices are certain to help you learn all about the world of various culinary delights.',
            'slug' => 'cooking',
        ]);
        Category::create([
            'name' => 'Crafts',
            'description' => 'With so many creative craft classes to explore from embroidery, sewing and knitting to pottery, candle making and woodworking, finding your new hobby is easy! If you love weaving, discover crochet and macrame courses. Learn flower pressing, jewellery making, quilting and origami skills. Awaken a new passion with an inspiring crafts class. ',
            'slug' => 'crafts',
        ]);
        Category::create([
            'name' => 'Dance',
            'description' => 'Dance into the rhythm of [location]\'s vibrant scene with our modern dance classes. Join the est dance classes [location] and unleash your passion for dance.',
            'slug' => 'dance',
        ]);
        Category::create([
            'name' => 'Drawing',
            'description' => 'Join the best drawing classes for beginners today and discover the joy of drawing today. Our expert instructors will guide you through every step of your artistic journey.',
            'slug' => 'drawing',
        ]);
        Category::create([
            'name' => 'Fashion',
            'description' => 'Taking a fashion course will open your eyes to the magical potential of clothing. It is not just an outfit, in the right hands and presented in the appropriate way it can send a message that words cannot convey. Learn the ropes of fashion and see yourself excel on one of our expert courses.',
            'slug' => 'fashion',
        ]);
        Category::create([
            'name' => 'Floristry',
            'description' => 'Learn the ropes of floristry and see yourself bloom in one of our expert courses. Discover how to make enchanted flower arrangements using sunflowers, wildflowers, roses and many more! Beginner floristry classes will help you grow your budding new skill and unleash inner florist. ',
            'slug' => 'floristry',
        ]);
        Category::create([
            'name' => 'Health and Beauty',
            'description' => 'Unlock new skills and embark on a rewarding career path in the dynamic world of beauty courses. Transform your passion into expertise with our health and beauty courses in [location].',
            'slug' => 'health-and-beauty',
        ]);
        Category::create([
            'name' => 'Jewellery Making',
            'description' => 'Learn all about the art and skill that goes into making jewellery. Express your creative side and begin learning all about the art of jewellery making because there’s a whole world of stunning jewellery waiting to be discovered.',
            'slug' => 'jewellery-making',
        ]);
        Category::create([
            'name' => 'Kids',
            'description' => 'From moulding clay in kids pottery classes to creating artwork in kids painting courses, let your children explore their imagination and grow their creative skills! Discover after school classes or kids weekend workshops. Whether kids want to learn how to draw in an art studio or cook in a kitchen, kids classes will help them reach their goals and find a new rewarding hobby. ',
            'slug' => 'kids',
        ]);
        Category::create([
            'name' => 'Knitting',
            'description' => 'If you love making knit clothing from chunky pom pom hats to technical bags, develop your knitting skills with an interactive workshop led by an expert teacher. If you are a whizz with a needle then why not try new knitting techniques such as beginners loom knitting? Flex your creative muscles and experiment with different patterns and colourful yarn and wool. Learn new techniques and methods in a lively studio or while relaxing at home with a quality knitting kit. ',
            'slug' => 'knitting',
        ]);
        Category::create([
            'name' => 'Languages',
            'description' => 'From Mandarin to Polish, discover languages from across the world. Whether you want to learn classical Latin or become a modern foreign languages translator, develop your spoken language skills with interactive language courses. Develop your cultural awareness and discover formal phrases as well as informal slang!',
            'slug' => 'languages',
        ]);
        Category::create([
            'name' => 'Mindfulness And Wellbeing',
            'description' => 'Practising mindfulness is an essential form of self-care. Not only does mindfulness benefit your wellbeing and mood, mindfulness also helps you self-soothe, relieve stress and relax. Explore calming art, crafts or meditation workshops that will teach you how to exercise mindfulness to promote a healthy wellbeing.',
            'slug' => 'mindfulness-and-wellbeing',
        ]);
        Category::create([
            'name' => 'Music',
            'description' => 'Explore your musical talent with our dynamic music classes in [location]. From beginner basics to advanced techniques, our expert instructors offer personalized instruction.',
            'slug' => 'music',
        ]);
        Category::create([
            'name' => 'Painting',
            'description' => 'Dive into the world of artistry with our painting classes in [location]. Our expert instructors will guide you through techniques and inspiration to unleash your creativity.',
            'slug' => 'painting',
        ]);
        Category::create([
            'name' => 'Photography',
            'description' => 'Join the best photography classes in [location], elevate your skills, and uncover the beauty of photography in one of the world\'s most iconic cities.',
            'slug' => 'photography',
        ]);
        Category::create([
            'name' => 'Pottery And Mosaics',
            'description' => 'Shrug your stresses away and embrace smoothing clay into unique ceramics. Whether you want to explore hand building, wheel throwing or Japanese ceramics such as raku, create your own pots and sculptures. Mould plant pots, vases and bowls or paint your homemade pottery pieces. Embark on a new ceramic journey with mosaic workshops. Arrange colourful tiles to create your own art which you can display with pride. ',
            'slug' => 'pottery-and-mosaics',
        ]);
        Category::create([
            'name' => 'Sculpture',
            'description' => 'Develop an extremely versatile and adaptable skill. Create unique sculptures in a variety of workshops. Explore pottery workshops to sculpt clay into ceramics, bronze casting sculpture courses, willow weaving sculptures, modelling wax figure sculpture classes, wire wrapping sculptures and many more! From wood carving sculpture pieces to making your own sculpture artwork through welding, discover your passion for creating different sculptures in a professional studio with expert guidance! ',
            'slug' => 'sculpture',
        ]);
        Category::create([
            'name' => 'Sewing',
            'description' => 'Sewing has featured heavily throughout history and will continue to do so for some time. If you are a whizz with a needle then you could look at getting into keeping this tradition alive and pick up and old-fashioned hobby and a unique skill. Tuition is cheaper and more practical than individual lessons when you learn as a group as you can spread the cost.',
            'slug' => 'sewing',
        ]);
        Category::create([
            'name' => 'Terrarium',
            'description' => 'Want self sustaining indoor house plants? Making your own large or tiny terrarium doesn’t have to be a prickly experience! Explore succulents, cactus plants and moss to fill glass jars, bowls or bottles and create your own small ecosystem. Whether you want a hanging terrarium or a green feature for your table, learn everything about terrarium making with interactive workshops. ',
            'slug' => 'terrarium',
        ]);
        Category::create([
            'name' => 'Upcycling',
            'description' => 'Breathe new life into your old clothing and furniture by building your upcycling skills. Learn how to revamp wooden furniture from cabinet doors, bookcases, chairs, desks, side tables and many more. Beginner upcycling workshops don’t stop at renovating furniture! Learn how to revive vintage fashion by restoring your favourite clothing. Engage your creativity, become enlightened to new materials and cherish your belongings with upcycling workshops.',
            'slug' => 'upcycling',
        ]);
        Category::create([
            'name' => 'Wine Tasting',
            'description' => 'You can be an expert or a complete novice to enjoy a wine tasting session. If you are there to find a new delicacy for your and your partner you won\'t be disappointed. Alternatively if you are just there to enjoy the alcohol on display and have fun you will get just as much out of the session.',
            'slug' => 'wine-tasting',
        ]);
        Category::create([
            'name' => 'Woodworking',
            'description' => 'Unleash your creativity and craftsmanship with woodworking classes in [location]. Explore the beauty of woodcraft and unleash your inner artisan today!',
            'slug' => 'woodworking',
        ]);

    }
}
