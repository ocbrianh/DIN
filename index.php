<?php
if (isset($_GET['Submit'])) {
  $url = trim($_GET['url']);
  $email = trim($_GET['email']);

  if (parse_url($url, PHP_URL_QUERY)) {
    $finalURL = $url . "&email=" . $email;
  } else {
    $finalURL = $url . "?email=" . $email;
  }

  $ch = curl_init($finalURL);
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_NOBODY, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 5);

  curl_exec($ch);
  $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

  if (curl_errno($ch) && curl_errno($ch) == 28) {
    echo "<div style='color: red;'>Error: Server took too long to respond.</div>";
  } else if ($status == 200) {
    echo "<div style='color: green;'>Success</div>";
  } else {
    echo "<div style='color: red;'>Error: " . $status . "</div>";
  }

  curl_close($ch);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
    <label for="url">URL:</label><br />
    <input type="url" name="url" /><br />
    <label for="email">Email:</label><br />
    <input type="email" name="email"><br />
    <input type="submit" name="Submit" value="Submit">
  </form>
</body>

</html>