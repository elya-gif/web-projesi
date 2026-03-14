    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<style>
.mega-footer{
    background:#EAE6E0;
    color:#fff;
    padding-top:60px;
    font-family:'Poppins', sans-serif;
}


.footer-newsletter{
    text-align:center;
    margin-bottom:50px;
    color:#1C1C1C;
}
.footer-newsletter h2{
    font-size:28px;
    font-weight:600;
    margin-bottom:10px;
}
.footer-newsletter p{
    color:#1C1C1C;
    margin-bottom:20px;
}
.footer-newsletter input{
    padding:12px 15px;
    width:260px;
    border:none;
    border-radius:30px 0 0 30px;
    outline:none;
}
.footer-newsletter button{
    padding:12px 20px;
    border:none;
    background:#c0392b;
    color:#fff;
    border-radius:0 30px 30px 0;
    cursor:pointer;
    transition:0.3s;
}
.footer-newsletter button:hover{
    background:#e74c3c;
}


.footer-container{
    display:flex;
    justify-content:space-between;
    flex-wrap:wrap;
    padding:0 40px;
}
.footer-box{
    width:230px;
    margin-bottom:40px;
}
.footer-box h3{
    font-family: "Cormorant Garamond", serif;
    margin-bottom:15px;
    font-weight:600;
    display:inline-block;
    padding-bottom:5px;
    color:#6B212C;
    
}

.footer-box p,
.footer-box li{
    color:#1C1C1C;
    font-size:14px;
}
.footer-box ul{
    list-style:none;
    padding:0;
}
.footer-box ul li{
    margin-bottom:8px;
}
.footer-box ul li a{
    text-decoration:none;
    color:#1C1C1C;
    transition:0.3s;
}
.footer-box ul li a:hover{
    color:#e74c3c;
    padding-left:5px;
}


.footer-bottom{
    text-align:center;
    border-top:1px solid #333;
    padding:20px;
    color:#aaa;
    font-size:14px;
}


.social-icons a{
    color:#1C1C1C;
    margin-right:15px;
    text-decoration:none;
    transition:0.3s;
}
.social-icons a:hover{
    color:#e74c3c;
}


@media(max-width:768px){
    .footer-container{
        flex-direction:column;
        align-items:center;
        text-align:center;
    }
    .footer-box{
        width:100%;
    }
}
</style>

<footer class="mega-footer">

    
    <div class="footer-newsletter">
        <h2>Megay Moda’dan İlham Alın ✨</h2>
        
    </div>

    
    <div class="footer-container">

        <div class="footer-box">
            <h3>Megay Moda</h3>
            <p>
                Sizlere terzilik hizmeti sunuyoruz.
                Her dikimde size özel bir hikâye yazıyoruz.
            </p>
        </div>

        <div class="footer-box">
            <h3>Hızlı Menü</h3>
            <ul>
                <li><a href="index.php">Ana Sayfa</a></li>
                <li><a href="iletisim.php">Hakkımızda</a></li>
                <li><a href="hizmetler.php">Hizmetler</a></li>
                
            </ul>
        </div>

        <div class="footer-box">
            <h3>Hizmetler</h3>
            <ul>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>

        <div class="footer-box">
            <h3>İletişim</h3>
            <p>📍 Adana / Çukurova</p>
            <p>📞 05xx xxx xx xx</p>
            <p>✉ info@megaymoda.com</p>
            

            <div class="social-icons mt-3">
                <a href="#">Instagram</a>
                
                
            </div>
        </div>

    </div>

    <div class="footer-bottom">
        © 2026 Megay Moda | Tüm Hakları Saklıdır.
    </div>

</footer>


</body>
</html>
</html>