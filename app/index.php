<?php
// =================================================================
// CONFIGURATION
// এখানে ওয়েবসাইটের সমস্ত তথ্য পরিবর্তন করা যাবে।
// =================================================================
$config = [
    'name' => 'RAHMAT AL ZAMI',
    'initials' => 'RAHMAT AL ZAMI',
    'tagline' => "I'm a professional Trader, Web Developer, and Cyber Security Expert based in Dubai. I love solving problems and building things for the digital world.",
    'roles' => [
        'Web Developer',
        'Cyber Security Expert',
        'Trader'
    ],
    'about' => [
        "Hello! I'm Rahmat Al Zami, currently living in Dubai. My main areas of expertise are Trading, Web Development, and Cyber Security.",
        "As a trader in the financial markets, I analyze market trends to find profitable opportunities. As a web developer, I build modern and efficient websites that provide great user experiences.",
        "My other great passion is cyber security. I work to secure the digital world and protect various systems from cyber-attacks. The intersection of technology and security always inspires me."
    ],
    'profile_image' => 'https://placehold.co/400x400/0a192f/64ffda?text=RAZ',
    'services' => [
        [
            'icon' => '<svg class="w-16 h-16 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>',
            'title' => 'Web Development',
            'description' => 'Building fast, responsive, and user-friendly websites and web applications using modern technologies.'
        ],
        [
            'icon' => '<svg class="w-16 h-16 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 20.417l4.162-3.524a1.23 1.23 0 011.644 0L12 19.236l3.194-2.693a1.23 1.23 0 011.644 0L21 20.417A12.02 12.02 0 0018.382 5.984z"></path></svg>',
            'title' => 'Cyber Security',
            'description' => 'Ensuring the security of websites, networks, and digital systems, and protecting them from potential cyber threats.'
        ],
        [
            'icon' => '<svg class="w-16 h-16 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>',
            'title' => 'Trading',
            'description' => 'Developing profitable trading strategies in stock, forex, and crypto markets through technical and fundamental analysis.'
        ]
    ],
    'projects' => [
        [
            'title' => 'E-commerce Platform',
            'description' => 'A full-featured e-commerce website with product management, user authentication, and a payment gateway.',
            'tags' => ['React', 'Node.js', 'MongoDB']
        ],
        [
            'title' => 'Trading Bot',
            'description' => 'An automated trading bot that executes trades on the crypto market based on a custom algorithm.',
            'tags' => ['Python', 'API', 'Data Analysis']
        ],
        [
            'title' => 'Vulnerability Scanner',
            'description' => 'A tool designed to scan web applications for common security vulnerabilities like XSS and SQL Injection.',
            'tags' => ['Python', 'Cyber Security', 'Automation']
        ]
    ],
    'contact' => [
        'email' => 'hi@imzami.com',
        'pitch' => "Want to know more about my work or discuss a project? I'm always open to new opportunities and collaborations. Feel free to reach out."
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($config['name']) ?> - Portfolio</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* Custom styles */
        body { font-family: 'Inter', sans-serif; background-color: #0a192f; color: #ccd6f6; }
        .gradient-text { background: linear-gradient(90deg, #64ffda, #00bfff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-fill-color: transparent; }
        .glass-effect { background: rgba(10, 25, 47, 0.85); backdrop-filter: blur(10px); border: 1px solid rgba(45, 212, 191, 0.2); }
        .card-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card-hover:hover { transform: translateY(-10px); box-shadow: 0 20px 30px -15px rgba(2, 12, 27, 0.7); }
        #typing-cursor { display: inline-block; width: 3px; height: 1.2em; background-color: #64ffda; animation: blink 0.7s infinite; margin-left: 4px; }
        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }
        #sidebar { transition: transform 0.3s ease-in-out; }
        .sidebar-link { display: block; padding: 1rem; border-radius: 0.5rem; transition: background-color 0.3s, color 0.3s; }
        .sidebar-link:hover { background-color: rgba(100, 255, 218, 0.1); color: #64ffda; }
    </style>
</head>
<body class="leading-normal tracking-normal">

    <!-- Navigation Bar -->
    <header class="fixed w-full z-30 top-0 glass-effect shadow-md">
        <div class="container mx-auto flex items-center justify-between p-4">
            <a href="#" class="text-2xl font-bold gradient-text"><?= htmlspecialchars($config['initials']) ?></a>
            <button id="open-menu" class="z-40 p-2">
                <svg class="w-6 h-6 text-slate-300 hover:text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
    </header>

    <!-- Sidebar Menu -->
    <aside id="sidebar" class="fixed top-0 right-0 h-full w-72 glass-effect transform translate-x-full z-50">
        <div class="flex justify-end p-4">
            <button id="close-menu" class="p-2">
                <svg class="w-6 h-6 text-slate-300 hover:text-teal-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <nav class="mt-8 px-6">
            <ul class="flex flex-col items-center text-center space-y-4 text-xl">
                <li><a href="#about" class="sidebar-link">About</a></li>
                <li><a href="#services" class="sidebar-link">Services</a></li>
                <li><a href="#projects" class="sidebar-link">Projects</a></li>
                <li><a href="#contact" class="sidebar-link mt-4 inline-block w-full text-center border border-teal-300 hover:bg-teal-300 hover:text-gray-900 text-teal-300 font-bold py-2 px-4 rounded-md transition duration-300">Contact</a></li>
            </ul>
        </nav>
    </aside>
    
    <div id="backdrop" class="fixed inset-0 bg-black bg-opacity-60 z-40 hidden"></div>

    <main class="container mx-auto px-6 pt-24">

        <!-- Hero Section -->
        <section id="hero" class="min-h-screen flex flex-col justify-center items-start">
            <div class="max-w-4xl">
                <p class="text-teal-300 text-lg mb-4">Hi, my name is</p>
                <h1 class="text-5xl md:text-7xl font-bold text-slate-100"><?= htmlspecialchars($config['name']) ?>.</h1>
                <h2 class="text-4xl md:text-6xl font-bold text-slate-400 mt-2">
                    I'm a <span id="typing-text"></span><span id="typing-cursor"></span>
                </h2>
                <p class="mt-6 max-w-xl text-lg text-slate-400">
                    <?= htmlspecialchars($config['tagline']) ?>
                </p>
                <a href="#contact" class="inline-block mt-8 bg-teal-400 text-gray-900 font-bold py-3 px-8 rounded-md hover:bg-teal-300 transition duration-300">Get In Touch</a>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-20">
            <h2 class="text-3xl font-bold mb-2 gradient-text">About Me</h2>
            <div class="w-24 h-1 bg-teal-300 mb-8"></div>
            <div class="flex flex-col md:flex-row items-center gap-10">
                <div class="md:w-2/3 text-slate-400 text-lg space-y-4">
                    <?php foreach ($config['about'] as $paragraph): ?>
                        <p><?= htmlspecialchars($paragraph) ?></p>
                    <?php endforeach; ?>
                </div>
                <div class="md:w-1/3 flex justify-center">
                    <div class="w-64 h-64 rounded-full overflow-hidden border-4 border-teal-300 shadow-lg">
                        <img src="<?= htmlspecialchars($config['profile_image']) ?>" alt="A picture of <?= htmlspecialchars($config['name']) ?>" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='https://placehold.co/400x400/0a192f/64ffda?text=Image';">
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="py-20">
            <h2 class="text-3xl font-bold mb-2 gradient-text">My Services</h2>
            <div class="w-24 h-1 bg-teal-300 mb-12"></div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($config['services'] as $service): ?>
                <div class="card-hover glass-effect rounded-lg p-6 text-center">
                    <div class="flex justify-center mb-4"><?= $service['icon'] ?></div>
                    <h3 class="text-2xl font-bold text-slate-100 mb-2"><?= htmlspecialchars($service['title']) ?></h3>
                    <p class="text-slate-400"><?= htmlspecialchars($service['description']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Projects Section -->
        <section id="projects" class="py-20">
            <h2 class="text-3xl font-bold mb-2 gradient-text">My Projects</h2>
            <div class="w-24 h-1 bg-teal-300 mb-12"></div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($config['projects'] as $project): ?>
                <div class="card-hover glass-effect rounded-lg p-6 flex flex-col">
                    <h3 class="text-xl font-bold text-slate-100 mb-3"><?= htmlspecialchars($project['title']) ?></h3>
                    <p class="text-slate-400 mb-4 flex-grow"><?= htmlspecialchars($project['description']) ?></p>
                    <div class="flex flex-wrap gap-2 mt-auto">
                        <?php foreach ($project['tags'] as $tag): ?>
                        <span class="bg-gray-700 text-teal-300 text-xs font-semibold px-2.5 py-0.5 rounded"><?= htmlspecialchars($tag) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-20 text-center">
            <h2 class="text-3xl font-bold mb-2 gradient-text">Get In Touch</h2>
            <div class="w-24 h-1 bg-teal-300 mb-8 mx-auto"></div>
            <p class="text-slate-400 text-lg max-w-2xl mx-auto mb-8"><?= htmlspecialchars($config['contact']['pitch']) ?></p>
            <a href="mailto:<?= htmlspecialchars($config['contact']['email']) ?>" class="inline-block bg-teal-400 text-gray-900 font-bold py-3 px-8 rounded-md hover:bg-teal-300 transition duration-300 text-lg">Say Hello</a>
        </section>

    </main>

    <!-- Footer -->
    <footer class="py-6 text-center">
        <p class="text-slate-400">&copy; <?= date('Y') ?> <?= htmlspecialchars($config['name']) ?>. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- Sidebar Functionality ---
            const openMenuBtn = document.getElementById('open-menu');
            const closeMenuBtn = document.getElementById('close-menu');
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('backdrop');
            const sidebarLinks = document.querySelectorAll('.sidebar-link');

            const openSidebar = () => {
                sidebar.classList.remove('translate-x-full');
                backdrop.classList.remove('hidden');
            };

            const closeSidebar = () => {
                sidebar.classList.add('translate-x-full');
                backdrop.classList.add('hidden');
            };

            openMenuBtn.addEventListener('click', openSidebar);
            closeMenuBtn.addEventListener('click', closeSidebar);
            backdrop.addEventListener('click', closeSidebar);
            sidebarLinks.forEach(link => {
                link.addEventListener('click', closeSidebar);
            });

            // --- Typing Effect ---
            const roles = <?= json_encode($config['roles']) ?>;
            let roleIndex = 0;
            let charIndex = 0;
            let isDeleting = false;
            const typingTextElement = document.getElementById('typing-text');

            function type() {
                const currentRole = roles[roleIndex];
                if (isDeleting) {
                    typingTextElement.textContent = currentRole.substring(0, charIndex - 1);
                    charIndex--;
                    if (charIndex === 0) {
                        isDeleting = false;
                        roleIndex = (roleIndex + 1) % roles.length;
                    }
                } else {
                    typingTextElement.textContent = currentRole.substring(0, charIndex + 1);
                    charIndex++;
                    if (charIndex === currentRole.length) {
                        isDeleting = true;
                        setTimeout(type, 2000);
                        return;
                    }
                }
                const typingSpeed = isDeleting ? 50 : 150;
                setTimeout(type, typingSpeed);
            }
            setTimeout(type, 500);

            // --- Smooth Scrolling ---
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetElement = document.querySelector(this.getAttribute('href'));
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>

</body>
</html>
