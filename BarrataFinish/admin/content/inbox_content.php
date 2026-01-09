<?php
// ===== FUNGSI PESAN WHATSAPP OTOMATIS (PANJANG + SESUAI REQUEST TYPE) =====

function generateWAResponse($name, $requestType) {

    $base = "Halo $name, terima kasih sudah menghubungi kami. Permintaan Anda telah kami terima dan saat ini sedang ditinjau oleh tim terkait. Mohon menunggu sebentar, kami akan segera memberikan informasi lebih lanjut setelah proses pengecekan selesai.";

    $extra = [
        'Pelatihan Fotogrametri - Remote Sensing' => 
            " Untuk layanan Pelatihan Fotogrametri / Remote Sensing, tim kami sedang mengecek jadwal pelatihan, ketersediaan instruktur, serta kebutuhan teknis yang diperlukan.",

        'Jasa Pembuatan Peta' => 
            " Untuk layanan Jasa Pembuatan Peta, tim kami sedang meninjau detail kebutuhan Anda, termasuk cakupan area, tipe data yang diperlukan, serta estimasi waktu pengerjaan.",

        'Survey' => 
            " Untuk layanan Survey, tim kami sedang melakukan pengecekan awal terkait lokasi, kebutuhan alat, dan estimasi durasi pengerjaan di lapangan.",

        'Lainnya' => 
            " Tim kami akan menyesuaikan respon berdasarkan kebutuhan Anda dan segera menghubungi jika diperlukan informasi tambahan."
    ];

    return $base . ($extra[$requestType] ?? $extra['Lainnya']);
}

?>

<div class="content-wrapper">
  <div class="content-section">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h5 class="mb-0"><i class="bi bi-inbox me-2"></i>Daftar Permintaan Layanan</h5>
        <small class="text-muted">Kelola semua permintaan layanan dari klien</small>
      </div>

      <!-- Filter Status -->
      <form method="GET" class="d-flex align-items-center gap-2">
        <label class="me-2 small">Filter:</label>
        <select name="status" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
          <option value="">Semua Status</option>
          <option value="Pending" <?= $statusFilter == 'Pending' ? 'selected' : '' ?>>Baru</option>
          <option value="In Progress" <?= $statusFilter == 'In Progress' ? 'selected' : '' ?>>Dikonfirmasi</option>
          <option value="Resolved" <?= $statusFilter == 'Resolved' ? 'selected' : '' ?>>Selesai</option>
        </select>
      </form>
    </div>

    <?php if (isset($_GET['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($_GET['success']) ?>
        <button class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($_GET['error']) ?>
        <button class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- Tabel -->
    <div class="table-responsive">
      <table class="table table-modern table-hover align-middle">
        <thead>
          <tr>
            <th style="width:100px">Tanggal</th>
            <th>Klien</th>
            <th style="width:150px">Jenis Layanan</th>
            <th>Pesan</th>
            <th style="width:120px">Status</th>
            <th style="width:320px">Aksi</th>
          </tr>
        </thead>
        <tbody>

          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>

              <?php
              $statusDisplay = match($row['status']) {
                'Pending' => 'baru',
                'In Progress' => 'dikonfirmasi',
                'Resolved' => 'selesai',
                default => strtolower($row['status'])
              };

              $badgeClass = match($statusDisplay) {
                'baru' => 'status-badge status-baru',
                'dikonfirmasi' => 'status-badge status-dikonfirmasi',
                'selesai' => 'status-badge status-pending',
                default => 'badge bg-secondary'
              };
              ?>

              <tr>
                <td>
                  <small><?= date('d/m/Y', strtotime($row['created_at'])) ?></small><br>
                  <small class="text-muted"><?= date('H:i', strtotime($row['created_at'])) ?></small>
                </td>

                <td>
                  <strong><?= htmlspecialchars($row['name']) ?></strong>
                  <div class="text-muted small">
                    <i class="bi bi-envelope"></i> <?= htmlspecialchars($row['email']) ?>
                  </div>
                  <?php if (!empty($row['whatsapp_number'])): ?>
                    <div class="small">
                      <i class="bi bi-whatsapp text-success"></i>
                      <?= htmlspecialchars($row['whatsapp_number']) ?>
                    </div>
                  <?php endif; ?>
                </td>

                <td>
                  <span class="badge bg-info text-dark"><?= htmlspecialchars($row['request_type']) ?></span>
                </td>

                <td>
                  <div style="max-height: 60px; overflow: hidden;">
                    <?= htmlspecialchars(substr($row['message'], 0, 100)) ?>
                    <?= strlen($row['message']) > 100 ? '...' : '' ?>
                  </div>

                  <?php if (strlen($row['message']) > 100): ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#detailModal<?= $row['id'] ?>" class="small">
                      Lihat selengkapnya...
                    </a>
                  <?php endif; ?>
                </td>

                <td>
                  <span class="<?= $badgeClass ?>"><?= ucfirst($statusDisplay) ?></span>
                </td>

                <td>
                  <div class="btn-group btn-group-sm">

                    <!-- Email -->
                    <a href="mailto:<?= $row['email'] ?>?subject=Re: <?= urlencode($row['request_type']) ?>"
                       class="btn btn-outline-primary">
                      <i class="bi bi-reply-fill"></i>
                    </a>

                    <!-- WhatsApp (AUTO MESSAGE) -->
                    <?php if (!empty($row['whatsapp_number'])): ?>
                      <?php $waText = generateWAResponse($row['name'], $row['request_type']); ?>
                      <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $row['whatsapp_number']) ?>?text=<?= urlencode($waText) ?>"
                         target="_blank" class="btn btn-outline-success">
                        <i class="bi bi-whatsapp"></i>
                      </a>
                    <?php endif; ?>

                    <!-- Konfirmasi -->
                    <?php if ($statusDisplay == 'baru'): ?>
                      <a href="update_status.php?id=<?= $row['id'] ?>&status=dikonfirmasi"
                         onclick="return confirm('Konfirmasi pesan?')"
                         class="btn btn-outline-success">
                        <i class="bi bi-check-circle"></i>
                      </a>
                    <?php endif; ?>

                    <!-- Selesai -->
                    <?php if ($statusDisplay != 'selesai'): ?>
                      <a href="update_status.php?id=<?= $row['id'] ?>&status=selesai"
                         onclick="return confirm('Tandai pesan selesai?')"
                         class="btn btn-outline-info">
                        <i class="bi bi-check-all"></i>
                      </a>
                    <?php endif; ?>

                    <!-- Reset ke Baru -->
                    <?php if ($statusDisplay != 'baru'): ?>
                      <a href="update_status.php?id=<?= $row['id'] ?>&status=baru"
                         onclick="return confirm('Kembalikan ke status baru?')"
                         class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise"></i>
                      </a>
                    <?php endif; ?>

                    <!-- Hapus -->
                    <a href="update_status.php?action=delete&id=<?= $row['id'] ?>"
                       onclick="return confirm('Hapus pesan ini secara permanen?')"
                       class="btn btn-outline-danger">
                      <i class="bi bi-trash"></i>
                    </a>

                  </div>
                </td>
              </tr>

              <!-- Modal Detail -->
              <div class="modal fade" id="detailModal<?= $row['id'] ?>">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                      <h5 class="modal-title">Detail Pesan - <?= htmlspecialchars($row['name']) ?></h5>
                      <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <dl class="row mb-0">
                        <dt class="col-sm-3">Nama</dt><dd class="col-sm-9"><?= htmlspecialchars($row['name']) ?></dd>
                        <dt class="col-sm-3">Email</dt><dd class="col-sm-9"><?= htmlspecialchars($row['email']) ?></dd>
                        <dt class="col-sm-3">WhatsApp</dt><dd class="col-sm-9"><?= $row['whatsapp_number'] ?? '-' ?></dd>
                        <dt class="col-sm-3">Jenis Layanan</dt><dd class="col-sm-9"><?= htmlspecialchars($row['request_type']) ?></dd>
                        <dt class="col-sm-3">Tanggal</dt><dd class="col-sm-9"><?= date('d M Y, H:i', strtotime($row['created_at'])) ?></dd>
                        <dt class="col-sm-3">Status</dt><dd class="col-sm-9"><span class="<?= $badgeClass ?>"><?= ucfirst($statusDisplay) ?></span></dd>

                        <dt class="col-sm-12 mt-3">Pesan:</dt>
                        <dd class="col-sm-12">
                          <div class="card p-3 bg-light">
                            <p class="mb-0"><?= nl2br(htmlspecialchars($row['message'])) ?></p>
                          </div>
                        </dd>

                      </dl>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                  </div>
                </div>
              </div>

            <?php endwhile; ?>

          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center py-5 text-muted">
                <i class="bi bi-inbox" style="font-size:3rem;"></i><br><br>
                Tidak ada pesan masuk
              </td>
            </tr>
          <?php endif; ?>

        </tbody>
      </table>
    </div>

    <!-- Statistik -->
    <?php if ($total > 0): ?>
      <div class="row mt-4 g-3">
        <div class="col-md-3">
          <div class="card text-center shadow-sm border-0">
            <div class="card-body">
              <h3 class="text-primary mb-2"><?= $total ?></h3>
              <small class="text-muted">Total Pesan</small>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card text-center shadow-sm border-0">
            <div class="card-body">
              <h3 class="text-danger mb-2"><?= $baru ?></h3>
              <small class="text-muted">Pesan Baru</small>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card text-center shadow-sm border-0">
            <div class="card-body">
              <h3 class="text-success mb-2"><?= $dikonfirmasi ?></h3>
              <small class="text-muted">Dikonfirmasi</small>
             </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card text-center shadow-sm border-0">
            <div class="card-body">
              <h3 class="text-warning mb-2"><?= $selesai ?></h3>
              <small class="text-muted">Selesai</small>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

  </div>
</div>
