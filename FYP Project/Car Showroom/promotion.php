<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Awesome Promotion!</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #ffffff;
      color: #333;
    }

    header {
      background-color: #f5511b;
      color: #fff;
      padding: 100px 0;
      text-align: center;
      clip-path: polygon(0 0, 100% 0, 100% 75%, 0% 100%);
      animation: headerFadeIn 1s ease-in-out;
    }

    @keyframes headerFadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h1 {
      font-size: 3em;
      margin-bottom: 10px;
      animation: textFadeIn 1.5s ease-in-out;
    }

    p {
      font-size: 1.2em;
      margin: 0;
      animation: textFadeIn 1.5s ease-in-out;
    }

    @keyframes textFadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .image-container {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-template-rows: auto;
      gap: 20px;
      margin: 40px auto;
      width: 90%;
    }

    .image-container img {
      border-radius: 15px;
      width: 100%;
      height: auto;
      object-fit: cover;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .image-container img:hover {
      transform: translateY(-10px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .image1 { grid-area: 1 / 1 / 3 / 2; }
    .image2 { grid-area: 1 / 2 / 2 / 4; }
    .image3 { grid-area: 2 / 2 / 4 / 3; }
    .image4 { grid-area: 2 / 3 / 4 / 4; }

    .description {
      background-color: #f7f7f7;
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin: 40px auto;
      padding: 40px;
      text-align: center;
      width: 90%;
    }

    .description h2 {
      font-size: 2.5em;
      margin-bottom: 20px;
    }

    .description p {
      line-height: 1.8;
      margin-bottom: 30px;
      font-size: 1.2em;
    }

    .description a {
      background-color: #f75325;
      color: #fff;
      padding: 15px 30px;
      border-radius: 5px;
      text-decoration: none;
      transition: background-color 0.3s ease;
      margin: 10px;
      display: inline-block;
    }

    .description a:hover {
      background-color: #e55d52;
    }

    .description .secondary-btn {
      background-color: #4CAF50;
    }

    .description .secondary-btn:hover {
      background-color: #45a049;
    }

    @media (max-width: 768px) {
      .image-container {
        grid-template-columns: 1fr;
        grid-template-rows: auto;
      }

      .image1 { grid-area: auto; }
      .image2 { grid-area: auto; }
      .image3 { grid-area: auto; }
      .image4 { grid-area: auto; }
    }


    nav {
      background-color: #f5511b;
      color: #fff;
      padding: 10px;
      text-align: center;
    }

    nav ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    nav ul li {
      margin: 0 10px;
      position: relative;
    }

    nav ul li a {
      color: #fff;
      text-decoration: none;
      padding: 5px 10px;
    }

    nav ul li a:hover {
      text-decoration: underline;
    }

  .countdown {
    text-align: center;
    margin: 40px auto;
  }

  #timer {
    font-size: 1.5em;
  }

  .inquiry {
    font-weight: bold;
    color: white; 
    font-size: 17px;
}
  </style>
</head>
<body>
                      <nav>
                      <ul class="nav">
      <li><a href="index.php" class="active">Home</a></li>
      <li><a href="carBrands.php">Brands</a></li>
      <li><a href="carService.php">Services</a></li>
      <li><a href="finance.php">Finance</a></li> 
      <li><a href="contactUs.php">Contact Us</a></li> 
    </ul>
                      </nav>

  <header>
    <h1>Don't Miss Out!</h1>
    <p>Our Incredible Promotion is Here!</p>
  </header>

  <section class="countdown">
  <h2>Promotion Ends In:</h2>
  <div id="timer">
    <span id="days"></span> Days 
    <span id="hours"></span> Hours 
    <span id="minutes"></span> Minutes 
    <span id="seconds"></span> Seconds
  </div>
</section>

  <section class="image-container">
    <img src="assets/images1/promotion3.png" alt="Promotion Image 1" class="image1">
    <img src="assets/images1/promotion2.png" alt="Promotion Image 2" class="image2">
    <img src="assets/images1/promotion4.png" alt="Promotion Image 3" class="image3">
    <img src="assets/images1/promotion5.png" alt="Promotion Image 4" class="image4">
  </section>

  <section class="description">
  <h2>Discover Unbeatable Deals on Quality Pre-Owned Cars!</h2>
  <p>Welcome to Car United Company, where your dream car is just a deal away. We pride ourselves on offering a wide range of high-quality, reliable pre-owned vehicles that cater to every budget and lifestyle. Our inventory includes everything from compact cars perfect for city driving to spacious SUVs ideal for family adventures.
Don't miss out on our exclusive promotions and financing options designed to make owning your next car easier than ever. Whether you're looking for a fuel-efficient sedan, a robust truck, or a luxurious ride, we've got you covered.</p>
<a href="contactUs.php">Explore Our Inventory & Drive Away with a Great Deal! <br> <span class="inquiry">Inquiry Us Now</span></a>
</section>


  <script>
    // Add some basic JavaScript functionality here (optional)
    // For example, you could add a fade-in effect to the images on page load:
    window.addEventListener('load', () => {
      const images = document.querySelectorAll('.image-container img');
      images.forEach((image, index) => {
        setTimeout(() => {
          image.style.opacity = 1;
        }, 200 * index);
      });
    });

    function countdown(endDate) {
    let days, hours, minutes, seconds;
    endDate = new Date(endDate).getTime();
  
    if (isNaN(endDate)) return;

    setInterval(calculate, 1000);

    function calculate() {
      let startDate = new Date().getTime();
      let timeRemaining = parseInt((endDate - startDate) / 1000);

      if (timeRemaining >= 0) {
        days = parseInt(timeRemaining / 86400);
        timeRemaining = (timeRemaining % 86400);

        hours = parseInt(timeRemaining / 3600);
        timeRemaining = (timeRemaining % 3600);

        minutes = parseInt(timeRemaining / 60);
        seconds = parseInt(timeRemaining % 60);

        document.getElementById("days").innerHTML = parseInt(days, 10);
        document.getElementById("hours").innerHTML = ("0" + hours).slice(-2);
        document.getElementById("minutes").innerHTML = ("0" + minutes).slice(-2);
        document.getElementById("seconds").innerHTML = ("0" + seconds).slice(-2);
      }
    }
  }

  (function () { 
    countdown('07/31/2024 12:00:00 AM'); 
  }());
  </script>
</body>
</html>
