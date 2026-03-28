<!DOCTYPE html>
<html>

<head>
    <title>PT-210 Print Test</title>
    <style>
        body {
            font-family: monospace;
            width: 80mm;
            margin: 0 auto;
        }

        .receipt {
            padding: 10px;
            border: 1px dashed #000;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="receipt">
        <h2 class="center">Boss Evs Shop</h2>
        <p>Date: 2026-03-27</p>
        <hr>
        <p>Item A .......... 50</p>
        <p>Item B .......... 30</p>
        <hr>
        <p>Total: 80</p>
        <p class="center">Thank you!</p>
    </div>

    <button onclick="window.print()">Print Receipt</button>

</body>

</html>