<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Site Başlığı</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
background:#f4f1ea;
padding-top:80px;
font-family: Arial, sans-serif;
}

.header{
position:fixed;
top:0;
width:100%;
display:flex;
align-items:center;
justify-content:space-between;
padding:50px 40px;
z-index:1000;
background:transparent;
transition:0.3s ease;
}

.header.scrolled{
background:#EAE6E0;
box-shadow:0 4px 15px rgba(0,0,0,0.05);
}

.menu-toggle{
position:absolute;
left:40px;
display:none;
align-items:center;
gap:8px;
font-size:20px;
cursor:pointer;
color:#1C1C1C;
background:none;
border:none;
}

.logo{
position:absolute;
left:50%;
transform:translateX(-50%);
}

.logo a{
text-decoration:none;
font-family: "Cormorant Garamond", serif;
font-size:48px;
letter-spacing:3px;
font-weight:600;
color:#1C1C1C;
}

.nav-icons{
position:absolute;
right:40px;
display:flex;
align-items:center;
gap:20px;
}

.nav-icons a{
text-decoration:none;
color:#1C1C1C;
font-size:22px;
transition:0.3s;
}

.nav-icons a:hover{
opacity:0.6;
}

.category-bar{
display:flex;
justify-content:center;
gap:30px;
padding:15px;
background:#f5f5f5;
margin-top:20px;
}

.category-bar a{
text-decoration:none;
color:black;
font-size:16px;
}

.mobile-menu{
position:fixed;
left:-260px;
top:0;
width:260px;
height:100%;
background:white;
padding-top:100px;
display:flex;
flex-direction:column;
transition:0.3s;
z-index:20000;
}

.menu-title{
font-size:20px;
font-weight:600;
padding:20px 25px;
border-bottom:1px solid #ddd;
margin-bottom:10px;
background:#EAE6E0;
}

.mobile-menu a{
padding:15px 25px;
text-decoration:none;
color:black;
font-size:18px;
}

.mobile-menu.active{
left:0;
}

@media (max-width:1200px){
.category-bar{
display:none;
}
}

@media (max-width:1200px){
.menu-toggle{
display:flex;
}
}

</style>
</head>

<body>

<header class="header" id="header">

<button class="menu-toggle">
<i class="fa-solid fa-bars"></i>
<span>Menü</span>
</button>

<div class="logo">
<a href="#">MEGAY MODA</a>
</div>

<div class="nav-icons">
<a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
<a href="#"><i class="fa-solid fa-basket-shopping"></i></a>
<a href="#"><i class="fa-solid fa-circle-user"></i></a>
</div>

</header>

<nav class="category-bar">

<a href="sayfalist.php">Kazak</a>
<a href="sayfalist.php">Gömlek</a>
<a href="sayfalist.php">Elbise</a>
<a href="sayfalist.php">Tişört</a>
<a href="sayfalist.php">Top | Body</a>
<a href="sayfalist.php">Etek</a>
<a href="sayfalist.php">Şort</a>

</nav>

<nav class="mobile-menu" id="mobileMenu">

<h3 class="menu-title">Kategoriler</h3>

<a href="sayfalist.php">Kazak</a>
<a href="sayfalist.php">Gömlek</a>
<a href="sayfalist.php">Elbise</a>
<a href="sayfalist.php">Tişört</a>
<a href="sayfalist.php">Top | Body</a>
<a href="sayfalist.php">Etek</a>
<a href="sayfalist.php">Şort</a>

</nav>

<script>

window.addEventListener("scroll", function(){
const header = document.getElementById("header");
header.classList.toggle("scrolled", window.scrollY > 50);
});

const menuBtn = document.querySelector(".menu-toggle");
const mobileMenu = document.getElementById("mobileMenu");

menuBtn.addEventListener("click", function(e){
e.stopPropagation();
mobileMenu.classList.toggle("active");
});

document.addEventListener("click", function(e){

if (!mobileMenu.contains(e.target) && !menuBtn.contains(e.target)) {
mobileMenu.classList.remove("active");
}

});

</script>

</body>
