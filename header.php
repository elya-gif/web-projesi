<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Başlığı</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

.header{
    position:sticky;
    top:0;
    background:#EAE6E0;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:20px 30px;
    border-bottom:1px solid #ddd;
    z-index:1000;
}

.menu{
    font-size:24px;
    cursor:pointer;
}


.logo{
    position:absolute;
    left:50%;
    transform:translateX(-50%);
}

.logo a{
    text-decoration:none;
    font-family: "Cormorant Garamond", serif;
    font-size: 32px;
    letter-spacing: 2px;
    font-weight: 600;
    color: #1C1C1C; 
}


.icon{
    display:flex;
    align-items:center;
    gap:15px; 
}

.icon a{
    text-decoration:none;
    color:black;
    font-size:20px;
    transition: transform 0.2s, color 0.2s;
}

.icon a:hover{
    transform: scale(1.1);
    color:#000;
}


@media(min-width:768px){
    .menu{
        font-size:26px;
    }
}
</style>
</head>
<body>

<header class="header">

    
    <div class="menu">☰</div>

    
    <div class="logo">
        <a href="#">MEGAY MODA</a>
    </div>

    
    <div class="icon">
        <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a> 
        <a href="#"><i class="fa-solid fa-basket-shopping"></i></a>
        <a href="#"><i class="fa-solid fa-circle-user"></i></a>
    </div>

</header>

</body>
</html>
