<div class="content-wrapper">
    <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" name="is_active" id="faqActive">
        <label class="form-check-label">Tampilkan</label>
    </div>


    <button class="btn btn-primary">Simpan FAQ</button>
    </form>


    <div class="card p-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Pertanyaan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $faqs->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['question']) ?></td>
                        <td>
                            <?= $row['is_active'] ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Nonaktif</span>' ?>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning"
                                onclick="editFAQ(<?= $row['id'] ?>,'<?= htmlspecialchars(addslashes($row['question'])) ?>','<?= htmlspecialchars(addslashes($row['answer'])) ?>',<?= $row['is_active'] ?>)">
                                Edit
                            </button>
                            <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                                onclick="return confirm('Hapus FAQ ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
</div>


<script>
    function editFAQ(id, q, a, active) {
        document.getElementById('faqId').value = id;
        document.getElementById('faqQuestion').value = q;
        document.getElementById('faqAnswer').value = a;
        document.getElementById('faqActive').checked = active == 1;
    }
</script>