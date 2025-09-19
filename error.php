<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.j4starter
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Joomla Error Object
$error = $this->error ?? null;

//
$code = $error ? $error->getCode() : 'Error';
$message = $error ? $error->getMessage() : JText::_('JERROR_AN_ERROR_HAS_OCCURRED');

?><!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
<head>
    <meta charset="utf-8">
    <title><?php echo $code; ?> - <?php echo htmlspecialchars($message); ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        body {
            font-family: system-ui, Arial, sans-serif;
            background: #fafbfc;
            color: #333;
            margin: 0;
        }

        .error-container {
            max-width: 600px;
            margin: 80px auto 0 auto;
            background: #fff;
            padding: 40px 30px 30px 30px;
            border-radius: 16px;
            box-shadow: 0 2px 18px rgba(0, 0, 0, 0.06);
            text-align: center;
        }

        h1 {
            font-size: 4rem;
            margin: 0 0 12px 0;
            color: #d32f2f;
        }

        h2 {
            font-size: 1.4rem;
            margin: 0 0 18px 0;
        }

        p {
            font-size: 1.1rem;
            color: #666;
        }

        .back-link {
            display: inline-block;
            margin-top: 24px;
            color: #1976d2;
            text-decoration: none;
            border-bottom: 1px dotted #1976d2;
        }

        .back-link:hover {
            color: #0d47a1;
            border-color: #0d47a1;
        }
    </style>
</head>
<body>
<div class="error-container">
    <h1><?php echo $code; ?></h1>
    <h2><?php echo htmlspecialchars($message); ?></h2>
    <?php if ($this->debug && $error) : ?>
        <p>
            <strong>File:</strong> <?php echo $error->getFile(); ?><br>
            <strong>Line:</strong> <?php echo $error->getLine(); ?><br>
            <strong>Trace:</strong>
        <pre style="text-align:left; white-space:pre-wrap; background:#f7f7f9; padding:1em; border-radius:8px; overflow:auto;"><?php echo htmlspecialchars($error->getTraceAsString()); ?></pre>
        </p>
    <?php endif; ?>
    <a href="<?php echo htmlspecialchars(JUri::base()); ?>" class="back-link">← Go to Homepage</a>
</div>
</body>
</html>
