<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
	<div class="profile-sidebar">
		<div class="profile-userpic">
			<img src="<?= $_SESSION['foto_perfil'] ?>" class="img-responsive" alt="">
		</div>
		<div class="profile-usertitle">
			<a href="novoMembro.php?pagina=3&idMembro=<?= $_SESSION['id_usuario'] ?>" title="Meu Perfil" style="color: black">
				<div class="profile-usertitle-name textNome"><?= $_SESSION['nome'] . " ". $_SESSION['sobre_nome'] ?></div>
			</a>
		</div>
		<div class="clear"></div>
	</div>
	<div class="divider"></div>
	<ul class="nav menu">
		<li <?= $dashboard ?>>
			<a href="dashboard.php?pagina=1"><i class="fas fa-home"></i>&nbsp; Dashboard</a>
		</li>
		<li <?= $configuracao ?>>
			<a href="configuracao.php?pagina=2"><i class="fas fa-tools"></i>&nbsp; Configuração</a>
		</li>
		<li <?= $membro ?>>
			<a href="membros.php?pagina=3&modo=1"><i class="fas fa-users"></i>&nbsp; Membros</a>
		</li>
		<li <?= $celula ?>>
			<a href="celula.php?pagina=4&modo=1"><i class="fas fa-project-diagram"></i>&nbsp; Células</a>
		</li>
		<li>
			<a href="../back/sair.php" style="color: red">
				<em class="fa fa-power-off">&nbsp;</em> Sair
			</a>
		</li>
	</ul>
</div>
<!--/.sidebar-->