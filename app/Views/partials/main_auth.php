<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>iDerm4U - <?= $title ?></title>

    <!-- Bootstrap core CSS -->
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url()?>/public/assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="<?= base_url()?>/public/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url()?>/public/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url()?>/public/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://www.google.com/recaptcha/api.js?render=<?= $site_key ?>"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('<?= $site_key ?>', {action: 'submit'}).then(function(token) {
                document.getElementById('g-recaptcha-response').value = token;
            });
        });
    </script>

</head>

<body>
    <div class="account-pages my-5 pt-sm-5">

        <div role="main" class="container">
            <?= $this->renderSection('isi') ?>
        </div>

    </div>
    
<!-- JAVASCRIPT -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js" integrity="sha512-pax4MlgXjHEPfCwcJLQhigY7+N8rt6bVvWLFyUMuxShv170X53TRzGPmPkZmGBhk+jikR8WBM4yl7A9WMHHqvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/3.0.7/metisMenu.min.js" integrity="sha512-o36qZrjup13zLM13tqxvZTaXMXs+5i4TL5UWaDCsmbp5qUcijtdCFuW9a/3qnHGfWzFHBAln8ODjf7AnUNebVg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/simplebar/6.2.4/simplebar.min.js" integrity="sha512-K//QeDiscFFAs5yljnbZCuoAmzv5KdtVY0W70WLQZ+BFCxi4PotspvxZwpaGJOao2l4oIQhgsHX5tHxyRe+YYw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.6/waves.min.js" integrity="sha512-MzXgHd+o6pUd/tm8ZgPkxya3QUCiHVMQolnY3IZqhsrOWQaBfax600esAw3XbBucYB15hZLOF0sKMHsTPdjLFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
<!-- App js -->
<script src="<?= base_url()?>/public/assets/js/app.js"></script>

</body>
</html>
