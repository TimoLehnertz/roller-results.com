        <footer class="footer">
            <div class="flex mobile align-center justify-space-arround margin bottom">
                <p class="font color gray">
                    This is a non-profit project. Keep it rolling with your donation
                </p>
                <div id="donate-button-container">
                    <div id="donate-button"></div>
                    <script src="https://www.paypalobjects.com/donate/sdk/donate-sdk.js" charset="UTF-8"></script>
                    <script>
                    PayPal.Donation.Button({
                        env:'production',
                        hosted_button_id:'PJ49N4UB2LG2E',
                        image: {
                            src:'https://www.paypalobjects.com/en_US/DK/i/btn/btn_donateCC_LG.gif',
                            alt:'Donate with PayPal button',
                            title:'PayPal - The safer, easier way to pay online!',
                        }
                    }).render('#donate-button');
                    </script>
                </div>
            </div>
            <br>
            <br>
            <div class="footer-flex">
                <div>
                    <p>Product</p>
                    <a href="/impressum/index.php">Impressum</a>
                    <a href="/impressum/datenschutz.php">Datenschutzerklärung</a>
                    <!-- <a href="/impressum/faq.php">Faq</a> -->
                    <!-- <a href="/impressum/features.php">Features</a> -->
                </div>
                <div>
                    <p>Platform</p>
                    <!-- <a href="/api/introduction.php">Developer API</a> -->
                    <a href="/blog/index.php">Dev blog</a>
                    <!-- <a href="/impressum/partners.php">Partners</a> -->
                </div>
                <div>
                    <p>Support</p>
                    <a href="/impressum/contact.php">Contact</a>
                </div>
            </div>
            <div class="lower">
                <p class="left">
                    © <?= date("Y")?> www.roller-results.com - All rights reserved
                </p>
                <p class="right">
                    <!-- <a href="#" class="no-underline"><i class="fab fa-youtube"></i></a> -->
                    <a target="_blank" rel="noopener noreferrer" href="https://github.com/TimoLehnertz/roller-results.com" class="no-underline"><i class="fab fa-github"></i></a>
                    <a target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/RollerResults" class="no-underline"><i class="fab fa-facebook"></i></a>
                    <a target="_blank" rel="noopener noreferrer" href="https://www.instagram.com/roller_results/" class="no-underline"><i class="fab fa-instagram"></i></a>
                    <!-- <a target="_blank" rel="noopener noreferrer" href="#" class="no-underline"><i class="fab fa-twitter"></i></a> -->
                </p>
            </div>
        </footer>
    </body>
</html>