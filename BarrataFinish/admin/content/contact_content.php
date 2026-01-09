<?php
// contact_content.php
$contactInfo = $contactInfo ?? [];

// Default values
$address = $contactInfo['address'] ?? 'Jl. Arcamanik Endah No.85A, Cisaranten Kulon, Kec. Arcamanik, Kota Bandung, Jawa Barat 40293';
$operating_hours = $contactInfo['operating_hours'] ?? "Senin-Jumat: 08:00 - 17:00 WIB\nSabtu: 08:00 - 12:00 WIB\nMinggu: Tutup";
$phone = $contactInfo['phone'] ?? '+62 22 1234 5678';
$email = $contactInfo['email'] ?? 'info@barrataglobal.tech';
$whatsapp = $contactInfo['whatsapp'] ?? '+62 812 3456 7890';
$website = $contactInfo['website'] ?? 'https://barrataglobal.tech';
$instagram = $contactInfo['instagram'] ?? '@barrataglobal';
$linkedin = $contactInfo['linkedin'] ?? 'barrata-technologies';
$facebook = $contactInfo['facebook'] ?? '';
$twitter = $contactInfo['twitter'] ?? '';
$maps = $contactInfo['maps_embed_url'] ?? '';
$lat = $contactInfo['latitude'] ?? '';
$lng = $contactInfo['longitude'] ?? '';
$desc = $contactInfo['location_description'] ?? 'Kantor kami berlokasi strategis di kawasan Arcamanik, Bandung.';
?>
<div class="content-wrapper">
    <div class="content-section">
        <h5><i class="bi bi-telephone me-2"></i>Informasi Kontak</h5>
        <hr>

        <!-- Notifikasi sukses / error -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>Data kontak berhasil diperbarui!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-x-circle me-2"></i>Gagal memperbarui data kontak!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form id="contactForm" action="contact_update.php" method="POST" novalidate>
            <!-- (Opsional) tambahkan token CSRF di sini jika implementasi ada -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                    <textarea id="address" class="form-control" rows="3" name="address" required><?= htmlspecialchars($address) ?></textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="operating_hours" class="form-label">Jam Operasional</label>
                    <textarea id="operating_hours" class="form-control" rows="3" name="operating_hours"><?= htmlspecialchars($operating_hours) ?></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="phone" class="form-label">Telepon <span class="text-danger">*</span></label>
                    <input id="phone" type="tel" class="form-control" name="phone" value="<?= htmlspecialchars($phone) ?>" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input id="email" type="email" class="form-control" name="email" value="<?= htmlspecialchars($email) ?>" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="whatsapp" class="form-label">WhatsApp</label>
                    <input id="whatsapp" type="tel" class="form-control" name="whatsapp" value="<?= htmlspecialchars($whatsapp) ?>" placeholder="+62 812 3456 7890">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="website" class="form-label">Website</label>
                    <input id="website" type="url" class="form-control" name="website" value="<?= htmlspecialchars($website) ?>" placeholder="https://example.com">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="instagram" class="form-label">Instagram</label>
                    <input id="instagram" type="text" class="form-control" name="instagram" value="<?= htmlspecialchars($instagram) ?>" placeholder="@username">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="linkedin" class="form-label">LinkedIn</label>
                    <input id="linkedin" type="text" class="form-control" name="linkedin" value="<?= htmlspecialchars($linkedin) ?>" placeholder="company-name">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="facebook" class="form-label">Facebook</label>
                    <input id="facebook" type="text" class="form-control" name="facebook" value="<?= htmlspecialchars($facebook) ?>" placeholder="page-name">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="twitter" class="form-label">Twitter</label>
                    <input id="twitter" type="text" class="form-control" name="twitter" value="<?= htmlspecialchars($twitter) ?>" placeholder="@username">
                </div>
            </div>

            <div class="mb-3">
                <label for="maps_embed_url" class="form-label">Google Maps Embed URL</label>
                <input id="maps_embed_url" type="url" class="form-control" name="maps_embed_url" value="<?= htmlspecialchars($maps) ?>" placeholder="https://www.google.com/maps/embed?pb=...">
                <small class="text-muted">Dapatkan URL embed dari Google Maps &rarr; Share &rarr; Embed a map</small>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="latitude" class="form-label">Latitude</label>
                    <input id="latitude" type="text" class="form-control" name="latitude" value="<?= htmlspecialchars($lat) ?>" placeholder="-6.9175">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="longitude" class="form-label">Longitude</label>
                    <input id="longitude" type="text" class="form-control" name="longitude" value="<?= htmlspecialchars($lng) ?>" placeholder="107.6191">
                </div>
            </div>

            <div class="mb-3">
                <label for="location_description" class="form-label">Deskripsi Lokasi</label>
                <textarea id="location_description" class="form-control" rows="3" name="location_description"><?= htmlspecialchars($desc) ?></textarea>
            </div>

            <div class="d-flex gap-2">
                <button id="submitBtn" type="submit" class="btn btn-modern btn-primary-modern">
                    <i class="bi bi-check"></i> Simpan Perubahan
                </button>
                <a href="dashboard.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>

    <!-- Preview -->
    <div class="content-section mt-4">
        <h5><i class="bi bi-eye me-2"></i>Preview Informasi Kontak</h5>
        <hr>
        <div class="row g-3">
            <!-- Kontak Utama -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="bi bi-telephone me-2"></i>Kontak Utama</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong><i class="bi bi-geo-alt text-primary me-2"></i>Alamat:</strong><br>
                            <small><?= nl2br(htmlspecialchars($address)) ?></small>
                        </div>

                        <div class="mb-3">
                            <strong><i class="bi bi-clock text-secondary me-2"></i>Jam Operasional:</strong><br>
                            <small><?= nl2br(htmlspecialchars($operating_hours)) ?></small>
                        </div>

                        <div class="mb-3">
                            <strong><i class="bi bi-telephone text-success me-2"></i>Telepon:</strong><br>
                            <small><?= htmlspecialchars($phone) ?></small>
                        </div>

                        <div class="mb-3">
                            <strong><i class="bi bi-envelope text-info me-2"></i>Email:</strong><br>
                            <small><?= htmlspecialchars($email) ?></small>
                        </div>

                        <div class="mb-0">
                            <strong><i class="bi bi-whatsapp text-success me-2"></i>WhatsApp:</strong><br>
                            <small><?= htmlspecialchars($whatsapp) ?></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Media Sosial & Maps -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="bi bi-share me-2"></i>Media Sosial & Lokasi</h6>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($website)): ?>
                            <div class="mb-2">
                                <i class="bi bi-globe"></i>
                                <a href="<?= htmlspecialchars($website) ?>" target="_blank" rel="noopener noreferrer" class="ms-2 text-decoration-none">Website</a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($instagram)): ?>
                            <div class="mb-2">
                                <i class="bi bi-instagram"></i>
                                <span class="ms-2"><?= htmlspecialchars($instagram) ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($linkedin)): ?>
                            <div class="mb-2">
                                <i class="bi bi-linkedin"></i>
                                <span class="ms-2"><?= htmlspecialchars($linkedin) ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($facebook)): ?>
                            <div class="mb-2">
                                <i class="bi bi-facebook"></i>
                                <span class="ms-2"><?= htmlspecialchars($facebook) ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($twitter)): ?>
                            <div class="mb-2">
                                <i class="bi bi-twitter"></i>
                                <span class="ms-2"><?= htmlspecialchars($twitter) ?></span>
                            </div>
                        <?php endif; ?>

                        <hr>

                        <div class="mb-2">
                            <strong><i class="bi bi-geo-alt-fill me-2"></i>Deskripsi Lokasi</strong>
                            <div class="small mt-1"><?= nl2br(htmlspecialchars($desc)) ?></div>
                        </div>

                        <!-- Maps preview: jika ada embed url gunakan iframe, jika tidak dan lat/lng ada, tampilkan link ke Google Maps -->
                        <?php if (!empty($maps)): ?>
                            <div class="mt-3">
                                <strong>Lokasi (Preview):</strong>
                                <div class="ratio ratio-16x9 mt-2">
                                    <iframe src="<?= htmlspecialchars($maps) ?>" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        <?php elseif (!empty($lat) && !empty($lng)): ?>
                            <?php
                                $gmLink = "https://www.google.com/maps/search/?api=1&query=" . urlencode($lat . ',' . $lng);
                            ?>
                            <div class="mt-3">
                                <strong>Lokasi (Link):</strong>
                                <div class="mt-2">
                                    <a href="<?= htmlspecialchars($gmLink) ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars($lat . ', ' . $lng) ?></a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="mt-3 text-muted small">Belum ada data lokasi yang dapat dipreview.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script: tombol submit pakai spinner dan disable untuk mencegah double submit -->
<script>
(function() {
    const form = document.getElementById('contactForm');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        if (!submitBtn) return;

        // basic HTML5 validity check
        if (!form.checkValidity()) {
            // biarkan browser menampilkan pesan validasi
            return;
        }

        // set spinner & disable
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan...';
        submitBtn.disabled = true;
    }, false);
})();
</script>
