    
    
    </main>

    <div class="container">
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li><a href="<?=ROOT?>/home" class="nav-link px-2 link-secondary">Головна</a></li>
                <?php if ($data['isAdmin']): ?>
                    <li><a href="<?=ROOT?>/managers" class="nav-link px-2 link-body-emphasis">Менеджери</a></li>
                    <li><a href="<?=ROOT?>/products/" class="nav-link px-2 link-body-emphasis">Меблі</a></li>
                    <li><a href="<?=ROOT?>/orders/" class="nav-link px-2 link-body-emphasis">Замовлення</a></li>
                <?php endif; ?>
                <?php if ($data['isAdmin'] == false && $data['department'] != 'sales'): ?>
                    <li><a href="<?=ROOT?>/tasks/" class="nav-link px-2 link-body-emphasis">Завдання</a></li>
                <?php endif; ?>
                <?php if ($data['isManager'] && $data['department'] != 'sales'): ?>
                        <li><a href="<?=ROOT?>/workers/" class="nav-link px-2 link-body-emphasis">Працівники</a></li>
                    <?php endif; ?>
                <?php if ($data['isManager']): ?>
                    <li><a href="<?=ROOT?>/products/" class="nav-link px-2 link-body-emphasis">Меблі</a></li>
                <?php endif; ?>
                <?php if ($data['isManager'] && $data['department'] == 'sales'): ?>
                    <li><a href="<?=ROOT?>/orders/" class="nav-link px-2 link-body-emphasis">Замовлення</a></li>
                <?php endif; ?>
            </ul>
            <p class="text-center text-body-secondary">&copy; 2024 Фабрика Меблів, Inc</p>
        </footer>
    </div>
    <script src="<?=ROOT?>/assets/js/bootstrap.bundle.min.js"></script>
    </body>
</html>