        </div>
    </main>
    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> SPACE ENGINE &mdash; Варіант 1, Лабораторна робота №6</p>
        </div>
    </footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(function(){ $('.data-table').DataTable({ pageLength: 10, language: { url: (document.documentElement.lang === 'uk' ? '//cdn.datatables.net/plug-ins/1.13.6/i18n/uk.json' : '//cdn.datatables.net/plug-ins/1.13.6/i18n/en-GB.json') } }); });
</script>
</body>
</html>
