<?= $this->extend('usr/layouts/pg_home') ?>
<?= $this->section('content') ?>
<!-- card -->
<div class="container-world">
    <div class="world-card">
        <div class="world-header">
            <div class="title">
                Selamat Datang di Steplane
            </div>
        </div>
        <div class="world-content">
            <div class="world-item">
                <div class="world-item-header">
                    <div class="profile"><img src="<?= base_url('assets/images/default.jpg') ?>" /> Konomon - Dev</div>
                </div>
                <div class="world-item-body">
                    <p>
                        Dear all user,<br>
                        Jika kalian menemukan bug, error, ataupun fitur yang tidak berfungsi. Mohon segera laporkan, dengan begitu website ini dapat dikembangan dengan lebih baik lagi. <br><br>
                        Contact : <br>
                        Instagram : @gho.farr
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-right">
        <div class="banner-item">
            <div class="sub-title">For donation :</div>
            <img src="<?= base_url().'/assets/images/saweria-me.png' ?>"/>
            <div class="banner-content">
                Or click this link <a href="https://saweria.co/ghofaralhasyim">saweria.co/ghofaralhasyim</a>
            </div>
        </div>
    </div>
</div>
<!-- end of card -->
<?= $this->endSection() ?>