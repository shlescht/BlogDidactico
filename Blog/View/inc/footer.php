
            <footer>
                <p class="italic"><strong><a href="<?=ROOT_URL?>" title="Homeage">Nutri<strong>IPIC</strong>cional</a></strong> creado por alumnos de 5to &nbsp; | &nbsp;
                <?php if (!empty($_SESSION['is_logged'])): ?>
                    Usted está logeado como Admin - <a href="<?=ROOT_URL?>?p=admin&amp;a=logout">Salir</a> &nbsp; | &nbsp;
                    <a href="<?=ROOT_URL?>?p=blog&amp;a=all">Ver todos los Post</a>
                <?php else: ?>
                    <a href="<?=ROOT_URL?>?p=admin&amp;a=login">Inicie Sesión</a>
                <?php endif ?>
                </p>
            </footer>
        </div>
    </body>
</html>
