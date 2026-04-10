<!DOCTYPE html>
<html>

<head>
    <title>Print Cart - RawBT</title>

</head>

<body style="font-family: Arial; text-align:center; padding-top:50px;">
    <h1>PharmaKiosk Receipt</h1>
    <script>
        function getCartFromUrl() {
            const params = new URLSearchParams(window.location.search);
            const cartStr = params.get("cart");
            if (!cartStr) return [];
            try {
                return JSON.parse(decodeURIComponent(cartStr));
            } catch (e) {
                return [];
            }
        }

        const cart = getCartFromUrl();

        function printCart() {
            if (!cart.length) {
                alert("Cart is empty!");
                return;
            }

            let text = "\x1B\x40"; // Initialize
            text += "\x1B\x61\x01\x1B\x45\x01PharmaKiosk\x1B\x45\x00\n";
            text += new Date().toLocaleString() + "\n";
            text += "List of Ordered Items" + "\n";
            text += "------------------------------\n";
            text += "\x1B\x61\x00";

            let total = 0;
            let d = 0;
            cart.forEach(item => {
                const subtotal = item.price * item.qty;
                total += subtotal;
                d += item.discount;
                text += item.name + "(" + item.brand + ")" + "\n";
                let left = `${item.qty} x ${item.price.toFixed(2)}`;
                let right = subtotal.toFixed(2);
                let space = 32 - (left.length + right.length);
                if (space < 1) space = 1;
                text += left + " ".repeat(space) + right + "\n";
            });

            text += "------------------------------\n";
            let totalLabel = "TOTAL";
            
            let totalValue = total.toFixed(2);
            let space = 32 - (totalLabel.length + totalValue.length);
            if (space < 1) space = 1;
            text += totalLabel + " ".repeat(space) + totalValue + "\n";
            text += "------------------------------\n";
            text += "\x1B\x61\x01Show order to the counter.\n";
            text += "\x1B\x61\x01Thank you!"+d+"\n";
            text += "\x1D\x56\x41\x10"; // Cut

            window.location.href = "rawbt:" + encodeURIComponent(text);

            // Optional: clear cart in main page
            setTimeout(() => {
                localStorage.removeItem('cart');
                window.close(); // Close the print tab
            }, 2000);
        }

        window.onload = function() {

            printCart();
            const docElm = document.documentElement;

            // Attempting to go fullscreen immediately
            if (docElm.requestFullscreen) {
                docElm.requestFullscreen().catch(err => {
                    console.log("Automatic fullscreen blocked. Awaiting user interaction.");

                    // Fallback: If blocked, wait for the user to click anywhere on the print page
                    document.addEventListener('click', () => {
                        docElm.requestFullscreen();
                    }, {
                        once: true
                    });
                });
            }
            localStorage.removeItem('cart');
            window.close();
            // window.location.href = "dashboard.php"; // Redirect back to main page
        };
    </script>
    

</body>

</html>