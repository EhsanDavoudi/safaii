<div class="container">
    <h1 class="text-center mt-5 mb-5">تحلیل روزانه بازار ارزهای دیجیتال</h1>

    <div id="news-container">
        <?php foreach ($newsData as $data) {
            // Determine the icon class based on sentiment
            $iconClass = $data['sentiment'] === 'positive' ? 'bi-arrow-up-circle-fill' :
                ($data['sentiment'] === 'negative' ? 'bi-arrow-down-circle-fill' : 'bi-dash-circle-fill'); ?>

            <div class="card">
                <div class="card-header">
                    <?= htmlspecialchars($data['symbols']) ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($data['title']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($data['article']) ?></p>
                    <p class="card-text">
                        <strong>تحلیل: </strong>
                        <span class="<?= htmlspecialchars($data['sentiment']) ?>">
                            <i class="bi <?= $iconClass ?> analysis-icon"></i>
                            <?= htmlspecialchars($data['sentiment']) ?>
                        </span>
                    </p>
                    <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#analyzeExp<?= $data['id'] ?>" aria-expanded="false" aria-controls="analyzeExp<?= $data['id'] ?>">
                        توضیحات تحلیل
                    </button>
                    <div class="collapse" id="analyzeExp<?= $data['id'] ?>">
                        <div class="card card-body">
                            <?= htmlspecialchars($data['explanation']) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>