<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Site Başlığı</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" stroke="black" fill="none" stroke-width="2" viewBox="0 0 24 24">
        <line x1="3" y1="6" x2="21" y2="6"></line>
        <line x1="3" y1="12" x2="21" y2="12"></line>
        <line x1="3" y1="18" x2="21" y2="18"></line>
    </svg>
    <span>Menü</span>
</button>

<div class="logo">
<a href="#">MEGAY MODA</a>
</div>

<div class="nav-icons">

    <a href="#">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="black" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
    </a>

    <a href="#">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="black" stroke-width="2" viewBox="0 0 24 24">
            <path d="M12 21s-7-4.5-9-8.5C1 8 3.5 5 6.5 5c2 0 3.5 1.5 5.5 3.5C14 6.5 15.5 5 17.5 5 20.5 5 23 8 21 12.5 19 16.5 12 21 12 21z"/>
</svg>
</a>

    <a href="#">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="black" stroke-width="2" viewBox="0 0 24 24">
            <path d="M6 6h15l-1.5 9h-13z"></path>
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="18" cy="21" r="1"></circle>
        </svg>
    </a>

    <a href="giris.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="black" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="7" r="4"></circle>
            <path d="M5.5 21a8.38 8.38 0 0 1 13 0"></path>
        </svg>
    </a>



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
