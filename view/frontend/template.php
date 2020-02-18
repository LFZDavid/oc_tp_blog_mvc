<!DOCTYPE html>

<html>

<head>
	<title><?= $title ?></title>
	<link rel="stylesheet" href="public/css/style.css"/>
</head>

<body>
	<a href="/oc_tp_blog_mvc/index.php"><button>Accueil</button></a>
	<a href="/oc_tp_blog_mvc/view/frontend/signup.php"><button>Signup</button></a>
	<a href="/oc_tp_blog_mvc/view/frontend/login.php"><button>Login</button></a>
	<a href="/oc_tp_blog_mvc/index.php?action=profile"><button>Profil</button></a>

	<?= $content ?>
</body>
</html>