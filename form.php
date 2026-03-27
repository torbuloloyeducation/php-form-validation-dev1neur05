<?php
// Initialize variables
$name = $email = $gender = $website = $phone = "";
$password = $confirmPassword = "";
$nameErr = $emailErr = $genderErr = $websiteErr = $phoneErr = "";
$passwordErr = $confirmPasswordErr = $termsErr = "";
$terms = "";
$attempt = 0;

// Count submission attempts
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$attempt = $_POST['attempt'] + 1;
} else {
$attempt = 0;
}

// Sanitize function
function test_input($data) {
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

// NAME
if (empty($_POST["name"])) {
$nameErr = "Name is required";
} else {
$name = test_input($_POST["name"]);
}

// EMAIL
if (empty($_POST["email"])) {
$emailErr = "Email is required";
} else {
$email = test_input($_POST["email"]);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
$emailErr = "Invalid email format";
}
}

// PHONE (Exercise 1)
if (empty($_POST["phone"])) {
$phoneErr = "Phone number is required";
} else {
$phone = test_input($_POST["phone"]);
if (!preg_match("/^[+]?[0-9 \-]{7,15}$/", $phone)) {
$phoneErr = "Invalid phone format";
}
}

// WEBSITE (Exercise 2)
if (!empty($_POST["website"])) {
$website = test_input($_POST["website"]);
if (!filter_var($website, FILTER_VALIDATE_URL)) {
$websiteErr = "Invalid URL format";
}
}

// PASSWORD (Exercise 3)
if (empty($_POST["password"])) {
$passwordErr = "Password is required";
} else {
$password = test_input($_POST["password"]);
if (strlen($password) < 8) {
$passwordErr = "Password must be at least 8 characters";
}
}

if (empty($_POST["confirmPassword"])) {
$confirmPasswordErr = "Confirm your password";
} else {
$confirmPassword = test_input($_POST["confirmPassword"]);
if ($password !== $confirmPassword) {
$confirmPasswordErr = "Passwords do not match";
}
}

// GENDER
if (empty($_POST["gender"])) {
$genderErr = "Gender is required";
} else {
$gender = test_input($_POST["gender"]);
}

// TERMS (Exercise 4)
if (!isset($_POST["terms"])) {
$termsErr = "You must agree to the terms and conditions";
} else {
$terms = "Accepted";
}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>PHP Form Validation</title>
<style>
.error { color: red; }
</style>
</head>
<body>

<h2>PHP Form Validation</h2>

<p><strong>Submission attempt:</strong> <?= $attempt ?></p>

<form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

<!-- Hidden counter -->
<input type="hidden" name="attempt" value="<?= $attempt ?>">

Name: <input type="text" name="name" value="<?= $name ?>">
<span class="error">* <?= $nameErr ?></span>
<br><br>

Email: <input type="text" name="email" value="<?= $email ?>">
<span class="error">* <?= $emailErr ?></span>
<br><br>

Phone: <input type="text" name="phone" value="<?= $phone ?>">
<span class="error">* <?= $phoneErr ?></span>
<br><br>

Website: <input type="text" name="website" value="<?= $website ?>">
<span class="error"><?= $websiteErr ?></span>
<br><br>

Password: <input type="password" name="password">
<span class="error">* <?= $passwordErr ?></span>
<br><br>

Confirm Password: <input type="password" name="confirmPassword">
<span class="error">* <?= $confirmPasswordErr ?></span>
<br><br>

Gender:
<input type="radio" name="gender" value="female" <?= ($gender=="female")?"checked":""; ?>> Female
<input type="radio" name="gender" value="male" <?= ($gender=="male")?"checked":""; ?>> Male
<span class="error">* <?= $genderErr ?></span>
<br><br>

<input type="checkbox" name="terms" <?= isset($_POST['terms']) ? 'checked' : '' ?>>
I agree to the terms and conditions
<span class="error">* <?= $termsErr ?></span>
<br><br>

<input type="submit" value="Submit">
</form>

<?php
// Display output if no errors
if ($_SERVER["REQUEST_METHOD"] == "POST" &&
empty($nameErr) && empty($emailErr) && empty($phoneErr) &&
empty($websiteErr) && empty($passwordErr) &&
empty($confirmPasswordErr) && empty($genderErr) &&
empty($termsErr)) {

echo "<h3>Your Input:</h3>";
echo "Name: $name <br>";
echo "Email: $email <br>";
echo "Phone: $phone <br>";
echo "Website: $website <br>";
echo "Gender: $gender <br>";
echo "Terms: $terms <br>";
}
?>

</body>
</html>
