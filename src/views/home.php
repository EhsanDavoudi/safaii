<!-- hero section  -->
<main>
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row justify-content-between align-content-between">
                <div class="col-lg-8 col-md-12 col-sm-12 text-content">
                    <h1>ربات معامله گری که منتظرش بودید رسید!</h1>
                    <p>تحلیل‌های فاندامنتال و اخبار روزانه، همگی در خدمت شما برای تصمیم‌گیری‌های بهتر و سریع‌تر</p>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <img src="../assets/images/bitcoin-logo.png" alt="" class="img-fluid">
                </div>

            </div>
        </div>
    </section>
</div>

    <section class="table-section">
        <div class="container mt-5 mb-5">
            <div class="d-flex justify-content-between small-price-table mb-4">
                <h2 class="mb-4">قیمت لحظه‌ای ارزهای دیجیتال</h2>
                <a class="nav-link" href="?mod=home&page=table">قیمت لحظه ای همه رمز ارزها
                    <img src="../assets/images/left-chevron.png" alt="">
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-borderless" id="cryptoList">
                    <thead>
                    <tr>
                        <th>نام</th>
                        <th>آخرین قیمت (تومان)</th>
                        <th>تغییر 24 ساعت</th>
                        <th>حجم معاملات 24 ساعت</th>
                        <th>نمودار هفتگی</th>
                    </tr>
                    </thead>
                    <tbody id="cryptoList">
            <?php
                echo renderCryptoTable(['btc', 'usdt', 'eth', 'shib', 'doge', 'trx']);
            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- services section  -->

    <section class="services-section" id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 services">
                    <div class="row row1">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card">
                                <img src="../assets/images/analyzing.png" class="card-img-top" alt="...">
                                <div>
                                    <h4 class="card-title">تحلیل‌های فاندامنتال</h4>
                                    <p class="card-text">ربات ما به‌طور مداوم اخبار اقتصادی را دنبال می‌کند تا شما از جدیدترین اطلاعات بهره‌مند شوید.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card">
                                <img src="../assets/images/decision-making%20(1).png" class="card-img-top" alt="...">
                                <div>
                                    <h4 class="card-title">تصمیم‌گیری هوشمندانه</h4>
                                    <p class="card-text">با استفاده از هوش مصنوعی، ربات بهترین زمان برای معاملات را تشخیص می‌دهد.</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row row2">

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card">
                                <img src="../assets/images/cancel.png" class="card-img-top" alt="...">
                                <div>
                                    <h4 class="card-title">امکان لغو معامله</h4>
                                    <p class="card-text">شما همیشه کنترل کامل روی معاملات خود دارید و می‌توانید در هر زمانی معامله را لغو کنید.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card">
                                <img src="../assets/images/earnings.png" class="card-img-top" alt="...">
                                <div>
                                    <h4 class="card-title">سوددهی تضمینی</h4>
                                    <p class="card-text">تحلیل‌های دقیق و تصمیم‌گیری‌های هوشمندانه به افزایش سود شما کمک می‌کند.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6 col-md-12 col-sm-12 text-content">
                    <h3>خدمات</h3>
                    <h2>تجربه معاملات هوشمند</h2>
                    <p>ربات هوش مصنوعی ما با بهره‌گیری از پیشرفته‌ترین الگوریتم‌ها و تحلیل‌های فاندامنتال، به شما کمک می‌کند تا بهترین زمان برای باز و بسته کردن معاملات را تشخیص دهید. دیگر نگران زمان‌بندی معاملات خود نباشید؛ همه چیز به صورت اتوماتیک و هوشمند انجام می‌شود.</p>
                </div>

            </div>
        </div>
    </section>
</main>