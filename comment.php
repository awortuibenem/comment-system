<?php
session_start();
include "config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<script src="https://cdn.tailwindcss.com"></script>
	<title>Comment UI</title>
	<script>
    function showReplyForm(commentId) {
        var replyForm = document.getElementById('replyForm_' + commentId);
        if (replyForm.classList.contains('hidden')) {
            replyForm.classList.remove('hidden');
        } else {
            replyForm.classList.add('hidden');
        }
    }

    function showRepliesModal(commentId) {
        var repliesModal = document.getElementById('repliesModal_' + commentId);
        if (repliesModal.classList.contains('hidden')) {
            repliesModal.classList.remove('hidden');
        } else {
            repliesModal.classList.add('hidden');
        }
    }
</script>
</head>

<?php
$total_comments_sql = "SELECT COUNT(*) AS total_comments FROM comments";
$total_comments_result = mysqli_query($conn, $total_comments_sql);
$total_comments_row = mysqli_fetch_assoc($total_comments_result);
$total_comments = $total_comments_row['total_comments'];
?>

<h3>Welcome <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?></h3>

<body class="bg-zinc-200">
	<div class="max-w-5xl mx-auto bg-white text-blue-500 w-full p-4 md:rounded mb-4 md:mt-4 text-lg font-semibold">
		Comments System
	</div>
	<div class="max-w-5xl mx-auto bg-white w-full p-4 md:rounded">
		<form action="" method="post">
			<div class="flex gap-4">
				<div class="bg-blue-300 text-blue-600 p-4 rounded">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
						<path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
					</svg>
				</div>
				<textarea class="h-14 w-full border outline-none p-2" name="comment" placeholder="Share your story..." required></textarea>
			</div>
			<button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded mt-2 block ml-auto">Comment</button>
		</form>

		<hr class="w-full my-4" />
<h2 class="text-zinc-800 mb-4"><?php echo $total_comments; ?> User comments</h2>
		<ul class="flex flex-col gap-4">

			<?php
			$sql = "SELECT comments.*, users.username 
			FROM comments 
			INNER JOIN users ON comments.user_id = users.id";
	$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
			?>
					<li>
						<div class="flex gap-4">
							<div class="bg-blue-300 text-blue-600 p-4 h-max rounded">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
									<path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
								</svg>
							</div>
							<div class="w-full">
								<h3 class="text-lg text-zinc-800"><?php echo $row['username']; ?></h3>
								<p class="text-zinc-500">
									<?php echo $row['comment']; ?>
								</p>
							</div>
						</div>
						<hr class="mt-2 mb-2" />
						<div class="flex items-center gap-10 ml-20 text-zinc-500">
							<button>
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">

								</svg>
							</button>
							<button>
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">

								</svg>
							</button>
							<div class="w-full"></div>
							<button class="px-6 py-2 bg-blue-500 text-white rounded" onclick="showReplyForm(<?php echo $row['id']; ?>)">
    Reply
</button>
<button class="px-6 py-2 bg-blue-500 text-white rounded" onclick="showRepliesModal(<?php echo $row['id']; ?>)">
    Replies
</button>

						</div>

						<form id="replyForm_<?php echo $row['id']; ?>" action="" method="post" class="hidden">
							<input type="hidden" name="comment_id" value="<?php echo $row['id']; ?>">
							<div class="flex gap-4 ml-20">
								<textarea class="h-14 w-full border outline-none p-2" name="msg" placeholder="Enter Reply..." required></textarea>
							</div>
							<button type="submit" name="reply" class="px-6 py-2 bg-blue-500 text-white rounded mt-2 block ml-auto">Send Reply</button>
						</form>

						<div id="repliesModal_<?php echo $row['id']; ?>" class="ml-20 hidden">
							<?php
							$comment_id = $row['id'];
							$replies_sql = "SELECT replies.*, users.username FROM replies INNER JOIN users ON replies.user_id = users.id WHERE replies.comment_id = $comment_id";
							$replies_result = mysqli_query($conn, $replies_sql);

							if (mysqli_num_rows($replies_result) > 0) {
								while ($reply_row = mysqli_fetch_assoc($replies_result)) {
							?>
									<div class="flex gap-4">
										<div class="bg-blue-300 text-blue-600 p-4 h-max rounded">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
												<path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
											</svg>
										</div>
										<div class="w-full">
											<h3 class="text-lg text-zinc-800"><?php echo $reply_row['username']; ?></h3>
											<p class="text-zinc-500">
												<?php echo $reply_row['reply']; ?>
											</p>
										</div>
									</div>
							<?php
								}
							} else {
								echo "No replies found.";
							}
							?>
						</div>

					</li>
			<?php
				}
			} else {
				echo "No comments found.";
			}
			?>

		</ul>
	</div>




</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['comment'])) {
		$stmt = $conn->prepare("INSERT INTO comments (user_id, comment) VALUES (?, ?)");
		$stmt->bind_param("is", $user_id, $comment_content);

		$user_id = $_SESSION['user_id'];
		$comment_content = $_POST['comment'];

		if ($stmt->execute()) {
			echo "Comment added successfully.";
		} else {
			echo "Error: " . $stmt->error;
		}
	}

	if (isset($_POST['reply'])) {
		$stmt = $conn->prepare("INSERT INTO replies (comment_id, user_id, reply) VALUES (?, ?, ?)");
		$stmt->bind_param("iis", $comment_id, $user_id, $reply_content);

		$user_id = $_SESSION['user_id'];
		$comment_id = $_POST['comment_id'];
		$reply_content = $_POST['msg'];

		if ($stmt->execute()) {
			echo "Reply added successfully.";
		} else {
			echo "Error: " . $stmt->error;
		}

		$stmt->close();
		$conn->close();
	}
}
?>