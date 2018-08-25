<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="assets/css/normalize.css">
		<link rel="stylesheet" href="assets/css/style.css">
		<title>[@title]</title>
	</head>
	<body>
		<div id="wrapper">
			<h1><a href="./index.php">[@title]</a></h1>
			<hr />
			<div id="main">
				<div id="[@postID]">
					<h1><a href="./post.php?id=[@postID]">[@postTitle]</a></h1>
					<small><i>Posted on [@date] by [@author]</i></small>
					<p>[@postContent]</p>
					<p>Tags: [@postTags]</p>
				</div>

			</div>
			<div id="sidebar">
				<h1>Tags</h1>
				<hr />
				<ul>
					[@tags]
				</ul>
			</div>
		</div>
	</body>
</html>
