<?php
$activePage = 'blog';
$pageTitle = 'Build & Deploy 2024 — Pipeline Notes & Highlights | JenniNexus';
$pageDescription = 'Notes and highlights from the 2024 build-and-deploy pipeline used for JenniNexus — tooling, tips, and a short demo video.';
$pageKeywords = 'build, deploy, pipeline, jenninexus, devops, automation';

// Define RES_ROOT for blog subdirectory
if (!defined('RES_ROOT')) {
  define('RES_ROOT', '/resources');
}
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
<?php include '../includes/head.php'; ?>
<body>

	<?php include '../includes/header.php'; ?>

	<article class="py-5">
		<div class="container" >
			<div class="row">
				<div class="col-lg-8 mx-auto">
					<header class="mb-5">
						<div class="mb-3">
							<span class="badge bg-primary">DevOps</span>
							<span class="text-muted ms-2">2024</span>
						</div>
						<h1 class="display-4 mb-4">Build & Deploy 2024 — Notes & Demo</h1>
						<p class="lead text-muted">An overview of the build-and-deploy flow with a short demo clip showing the pipeline in action.</p>
						<hr>
					</header>

<div class="post-content glass-panel p-4 rounded-4 shadow-sm">
						<p>This post collects the main ideas behind the build-and-deploy pipeline used here on JenniNexus. The pipeline automates asset building, sync, and publish steps to keep the site fast and reproducible.</p>

						<p>Below is a short demo clip demonstrating the primary build & deploy flow.</p>

						<!-- TikTok Embed - Vibecoding -->
						<div class="mb-4 d-flex justify-content-center">
							<blockquote class="tiktok-embed" cite="https://www.tiktok.com/@jenninexus/video/7507138873131093290" data-video-id="7507138873131093290" style="max-width: 605px;min-width: 325px;" > 
								<section> 
									<a target="_blank" title="@jenninexus" href="https://www.tiktok.com/@jenninexus?refer=embed">@jenninexus</a> <a title="vibecoding" target="_blank" href="https://www.tiktok.com/tag/vibecoding?refer=embed">#vibecoding</a> like a maniac 💪👽 <a title="cursorai" target="_blank" href="https://www.tiktok.com/tag/cursorai?refer=embed">#cursorai</a> <a title="aitools" target="_blank" href="https://www.tiktok.com/tag/aitools?refer=embed">#aitools</a> <a title="livecoder" target="_blank" href="https://www.tiktok.com/tag/livecoder?refer=embed">#livecoder</a> <a title="seattleindie" target="_blank" href="https://www.tiktok.com/tag/seattleindie?refer=embed">#seattleindie</a> <a title="deploy" target="_blank" href="https://www.tiktok.com/tag/deploy?refer=embed">#deploy</a> <a title="mvc" target="_blank" href="https://www.tiktok.com/tag/mvc?refer=embed">#mvc</a> <a title="a16z" target="_blank" href="https://www.tiktok.com/tag/a16z?refer=embed">#a16z</a> <a title="unitygamedev" target="_blank" href="https://www.tiktok.com/tag/unitygamedev?refer=embed">#unitygamedev</a> <a title="webdev" target="_blank" href="https://www.tiktok.com/tag/webdev?refer=embed">#webdev</a> <a title="futurearchitect" target="_blank" href="https://www.tiktok.com/tag/futurearchitect?refer=embed">#futurearchitect</a> <a title="metahorizons" target="_blank" href="https://www.tiktok.com/tag/metahorizons?refer=embed">#metahorizons</a> <a title="metaquest" target="_blank" href="https://www.tiktok.com/tag/metaquest?refer=embed">#metaquest</a> <a title="vrgamedev" target="_blank" href="https://www.tiktok.com/tag/vrgamedev?refer=embed">#vrgamedev</a> <a title="indiegamestudio" target="_blank" href="https://www.tiktok.com/tag/indiegamestudio?refer=embed">#indiegamestudio</a> <a target="_blank" title="♬ Follow Me - Simon Doty &#38; My Friend &#38; Tailor" href="https://www.tiktok.com/music/Follow-Me-7189569352801191937?refer=embed">♬ Follow Me - Simon Doty &#38; My Friend &#38; Tailor</a> 
								</section> 
							</blockquote> 
							<script async src="https://www.tiktok.com/embed.js"></script>
						</div>

						<div class="card border-0 shadow-sm mb-4">
							<div class="card-body">
								<div class="ratio ratio-16x9">
									<iframe src="https://www.youtube.com/embed/8F3T78MQjys" title="Build & Deploy Demo" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
								</div>
								<div class="mt-3">
									<a href="https://youtu.be/8F3T78MQjys" target="_blank" class="btn btn-sm btn-outline-secondary">Open on YouTube</a>
								</div>
							</div>
						</div>

						<p>For the full pipeline scripts and notes, see the <a href="/scripts/">scripts/</a> directory and the <code>scripts/build-and-deploy.ps1</code> entry point.</p>
					</div>

					<div class="mt-5">
						<button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="devops" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('devops') : null">DevOps</button>
						<button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="build" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('build') : null">Build</button>
						<button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="deploy" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('deploy') : null">Deploy</button>
					</div>

					<div class="mt-5 pt-4 border-top">
						<a href="../blog.php" class="btn btn-outline-primary">
							<i class="fa-solid fa-arrow-left me-2"></i>Back to Blog
						</a>
					</div>

				</div>
			</div>
		</div>
	</article>

	<?php include '../includes/footer.php'; ?>

</body>
</html>
