<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chase & Cherie Cakes</title>
    <link rel="stylesheet" href="/css/home.css">
</head>

<body>
    

    <nav class="navbar">
    <div class="nav-container">
        <div class="nav-logo">
            <h1>Chace and Cherries Cakes and Cafe</h1>
        </div>
        <ul class="nav-menu">
            <li><a href="#home">Order Now</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact Us</a></li>
            <li><a href="{{ route('role.selection') }}" class="login-btn">Login</a></li>
        </ul>
    </div>
</nav>

<header>
    <h1>Chase & Cherie Cakes</h1>
    <p>Delicious cakes for every celebration!</p>
</header>

<div class="hero-section">
    <h2>Your Dream Cake, Made Just for You</h2>
    <p>Personalized and custom-designed cakes for every celebration. Freshly baked, handcrafted, uniquely yours.</p>
    <button class="hero-btn">Order Now</button>
</div>

<div class="section">
    <h2>Our Featured Cakes</h2>
    <div class="products">
        <div class="product-card">
            <img src="/images/bluecake.jpg" alt="Blueberry Cake">
            <h3>Blueberry Cakes</h3>
            <p>Rich and creamy chocolate delight</p>
            <button class="order-btn">Order Now</button>
        </div>
        <div class="product-card">
            <img src="/images/customizecar.jpg" alt="Customize Car Cake">
            <h3>Customize Car Cake</h3>
            <p>Fresh strawberries with soft sponge</p>
            <button class="order-btn">Order Now</button>
        </div>
        <div class="product-card">
            <img src="/images/rivonchocolate.jpg" alt="Cheesecake">
            <h3>Cheesecake</h3>
            <p>Creamy cheesecake with graham crust</p>
            <button class="order-btn">Order Now</button>
        </div>
         <div class="product-card">
            <img src="/images/bdaycakes.jpg" alt="birthday Cakes">
            <h3>Cheesecake</h3>
            <p>Creamy cheesecake with graham crust</p>
            <button class="order-btn">Order Now</button>
        </div>
    </div>
</div>

<div class="how-it-works">
    <div class="how-it-works-content">
        <h2>🧁 How It Works</h2>
        
        <div class="step">
            <h3>1. Choose a Design</h3>
            <p>Select a theme or upload your own cake inspiration.</p>
        </div>
        
        <div class="step">
            <h3>2. Customize</h3>
            <p>Pick your size, flavor, icing, colors, and decorations.</p>
        </div>
        
        <div class="step">
            <h3>3. We Bake & Deliver</h3>
            <p>Freshly made and delivered on your scheduled date.</p>
        </div>
    </div>
    
    <div class="how-it-works-image">
        <img src="{{ asset('/images/howitworks.jpg') }}" alt="Dessert Buffet">
    </div>
</div>

<div class="section">
    <h2>About Us</h2>
    <p>Chase & Cherie Cakes is your friendly neighborhood bakery serving freshly baked cakes every day. We specialize in custom cakes for birthdays, weddings, and special events!</p>
</div>

<footer>
    &copy; 2026 Chase & Cherie Cakes | Contact us: info@cakeshop.com
</footer>

</body>
</html>
