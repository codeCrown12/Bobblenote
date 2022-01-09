<?php
session_start();
include 'connection.php';
include 'functions.php';

$rand = rand();
$selector = "";

//Check if user is logged in
if (isset($_SESSION['w_email'])) {
    $selector = $_SESSION['w_email'];
}
//Get user details
$user_details = get_writer_details($connection, $selector);
include 'compdefaulterscheck.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and conditions of use - Bobblenote</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css">
    <style>
        .content p{
            font-size: 16.5px;
        }
    </style>
</head>
<body>
    <!-- Navbar component -->
    <?php include 'header.php'; ?>
    <!-- End of navbar component -->

    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="content">
                    <div class="content-header">
                        <h2>Bobblenote Terms of Use</h2>
                    </div>
                    <!-- The links to the sections of the page (Note you can add or remove from this list)-->
                    <div class="content-links">
                        <p><a href="#introduction">1. Introduction</a></p>
                        <p><a href="#changes">2. Changes to the Agreements</a></p>
                        <p><a href="#service">3. Using our Service</a></p>
                        <p><a href="#tparty">4. Third Party Applications and Devices</a></p>
                        <p><a href="#content">5. User-Generated Content</a></p>
                        <p><a href="#privacy">6. Privacy Policy</a></p>
                        <p><a href="#mods">7. Routine modifications</a></p>
                        <p><a href="#disclaimer">8. Warranty disclaimer</a></p>
                        <p><a href="#indemnify">9. Indemnification</a></p>
                        <p><a href="#arbitration">10. Mandatory arbitration, severability and resolution</a></p>
                        <p><a href="#support">11. Customer Support</a></p>
                        <p><a href="#contactus">12. Contact Us</a></p>
                    </div>
                    <!-- The main content body -->
                    <div class="content-body">
                        <div id="introduction">
                            <h3>1. Introduction</h3>
                            <b>Thanks for choosing Bobblenote. Bobblenote creates a space where individuals of variegated fields of study, with dissimilar but tentative views come to find and/or create content that reforms and enlightens a sombre mind. Here experts and up-and-comers alike delve into the core of any subject, bringing fresh perspectives to the body of knowledge. By signing up or otherwise using any of our services, including all associated features and functionalities, websites and user interfaces, as well as all content and software applications associated with our services, or accessing any content or material that is made available through the Service, you are entering into a binding contract with Bobblenote Inc.</b>
                            <br> <br>
                            <p>Your agreement with us includes these Terms and any additional terms that you agree to, as discussed in the Entire Agreement section below, other than terms with any third parties (collectively, the "Agreements"). The Agreements include terms regarding future changes to the Terms, Terms of Payment, automatic renewals, rights you granted us, confidentiality, and resolution of disputes by arbitration instead of in court. If you wish to review the terms of the Agreements, the current effective version of the Agreements can be found on Bobblenote's website. You acknowledge that you have read and understood the Agreements, accept these Agreements, and agree to be bound by them. If you don't agree with (or cannot comply with) the Agreements, then you may not use Bobblenote's services or access any Content.</p>
                        </div>
                        <div id="changes">
                            <h3>2. Changes to the Agreements</h3>
                            <p>Occasionally we may make changes to the Agreements. When we make material changes to the Agreements, we'll provide you with notice as appropriate under the circumstances, e.g., by displaying a prominent notice within the Service or by sending you an email. In some cases, we will notify you in advance, and your continued use of the Service after the changes have been made will constitute your acceptance of the changes. Please therefore make sure you read any such notice carefully. If you do not wish to continue using the Service under the new version of the Agreements, you may terminate your account by contacting us or doing so manually.</p>
                        </div>
                        <div id="service">
                            <h3>3. Using our Service</h3>
                            <b>We grant you limited, non-exclusive, revocable permission to make use of the our services, and limited, non-exclusive, revocable permission to make personal, non-commercial use of the Content (collectively, "Access"). This Access shall remain in effect until and unless terminated by you or Bobblenote. You promise and agree that you are using the Bobblenote Service and Content for personal or competitions's use and that you will not redistribute or transfer the Bobblenote Service or the Content without prior notice to owner of the said content.</b>
                            <br> <br>
                            <p>All Bobblenote trademarks, trade names, logos, domain names, and any other features of the Bobblenote brand are the sole property of Bobblenote or its licensors. The Agreements do not grant you any rights to use any Bobblenote Brand Features whether for commercial or non-commercial use.</p>
                            <br>
                            <p>The Bobblenote software applications and the Content are not sold or transferred to you, and Bobblenote and its licensors retain ownership of all copies of the Bobblenote software applications and Content even after installation on your personal computers, mobile handsets, tablets, wearable devices, and/or other devices ("Devices").</p>
                            <br>
                            <p>Third party software (for example, open source software libraries) included in the Bobblenote Service are made available to you under the relevant third party software library's license terms as published in the help or settings section of our desktop and mobile client and/or on our website</p>
                            <br>
                            <p>BOBBLENOTE WOULD LIKE YOU TO NOTE THAT FOR EACH COMPETITION HOSTED BY OUR USERS, RESOURCES DEPOSITED TO FUND SUCH COMPETITION IS NON-REFUNDABLE PROVIDED THERE IS AT LEAST ONE REGISTERED ACTIVE PARTICIPANT</p>
                        </div>
                        <div id="tparty">
                            <h3>4. Third Party Applications and Devices</h3>
                            <b>The Bobblenote Service is integrated with or may otherwise interact with third party applications, websites, and services ("Third Party Applications") and third party Devices to make the services available to you. These Third Party Applications and Devices may have their own terms and conditions of use and privacy policies and your use of these Third Party Applications and Devices will be governed by and subject to such terms and conditions and privacy policies. You understand and agree that Bobblenote does not endorse and is not responsible or liable for the behavior, features, or content of any Third Party Application or Device or for any transaction you may enter into with the provider of any such Third Party Applications and Devices, nor does Bobblenote warrant the compatibility or continuing compatibility of the Third Party Applications and Devices with the Service.</b>
                        </div>
                        <div id="content">
                            <h3>5. User-Generated Content</h3>
                            <b>Bobblenote may, but has no obligation to, monitor, review, or edit User Content. In all cases, Bobblenote reserves the right to remove or disable access to any User Content for any or no reason, including User Content that, in Bobblenote's sole discretion, violates the Agreements. Bobblenote may take these actions without prior notification to you or any third party. Removal or disabling of access to User Content shall be at our sole discretion, and we do not promise to remove or disable access to any specific User Content.</b>
                            <br> <br>
                            <p>You promise that, with respect to any User Content you post on Bobblenote,</p>
                            <br>
                            <p>You own or have the right to post such User Content, and</p>
                            <br>
                            <p>Such User Content, or its use by Bobblenote as contemplated by the Agreements, does not violate the Agreements or any other rights set forth within the User guidelines, applicable law, or the intellectual property, publicity, personality, or other rights of others or imply any affiliation with or endorsement of you or your User Content by Bobblenote or any other institution, business, label, entity or individual without express written consent from Bobblenote or such individual or entity.</p>
                            <br>
                            <p>Bobblenote holds no responsibility for the advertising or marketing of any competition hosted on our platform.</p>
                            <br>
                            <p>You are solely responsible for all User Content that you post. Bobblenote is not responsible for User Content nor does it endorse any opinion contained in any User Content. YOU AGREE THAT IF ANYONE BRINGS A CLAIM AGAINST BOBBLENOTE RELATED TO USER CONTENT THAT YOU POST, THEN, TO THE EXTENT PERMISSIBLE UNDER LOCAL LAW, YOU WILL INDEMNIFY AND HOLD BOBBLENOTE HARMLESS FROM AND AGAINST ALL DAMAGES, LOSSES, AND EXPENSES OF ANY KIND (INCLUDING REASONABLE ATTORNEY FEES AND COSTS) ARISING OUT OF SUCH CLAIM. UPON MANUAL 
                            DEACTIVATION OF ACCOUNT, ANY AND EVERY CONTENT UPLOADED PRIOR TO DEACTIVATION STILL REMAINS ACCESSIBLE TO BOBBLENOTE AND WOULD BE RETRIEVED AND ACCREDITED TO YOU IF CASES OF LITIGATION ARISES</p>
                        </div>
                        <div id="privacy">
                            <h3>6. Privacy Policy</h3>
                            <b>You grant Bobblenote a non-exclusive, transferable, sub-licensable, royalty-free, perpetual, irrevocable, fully paid, worldwide license to use, reproduce, make available to the public (e.g. perform or display), publish, translate, modify, create derivative works from, and distribute any of your User Content in connection with the Service through any medium, whether alone or in combination with other Content or materials, in any manner and by any means, method or technology, whether now known or hereafter created.</b>
                            <br> <br>
                            <p>In consideration for the rights granted to you under the Agreements, you grant us the right:</p>
                            <br>
                            <p>To allow the Bobblenote Service to use the processor, bandwidth, and storage hardware on your Device in order to facilitate the operation of the Service,</p>
                            <br>
                            <p>To provide advertising and other information to you, and</p>
                            <br>
                            <p>To allow our business partners to do the same. In any part of the Bobblenote Service, the Content you access, including its selection and placement, may be influenced by commercial considerations</p>
                            <br>
                            <p>If you provide feedback, ideas or suggestions to Bobblenote in connection with the Bobblenote Service or Content ("Feedback"), you acknowledge that the Feedback is not confidential and you authorize Bobblenote to use that Feedback without restriction and without payment to you. Feedback is considered a type of User Content.</p>
                        </div>
                        <div id="mods">
                            <h3>7. Routine modifications</h3>
                            <b>Bobblenote reserves the rights to making changes to the application, improve performance, correct problems, or enhance security. Our routine changes standards would include change request, review, and approval procedures. Our routine changes would be duly passed accross quickly to affected parties of all changes. Our modifications and patches would be coordinated through a centralized change management process.</b>
                        </div>
                        <div id="disclaimer">
                            <h3>8. Warranty disclaimer</h3>
                            <b>YOU UNDERSTAND AND AGREE THAT THE BOBBLENOTE SERVICE IS PROVIDED "AS IS" AND "AS AVAILABLE," WITHOUT EXPRESS OR IMPLIED WARRANTY OR CONDITION OF ANY KIND. BOBBLENOTE AND ALL OWNERS OF THE CONTENT MAKE NO REPRESENTATIONS AND DISCLAIM ANY WARRANTIES OR CONDITIONS OF SATISFACTORY QUALITY, MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, OR NON-INFRINGEMENT. NEITHER BOBBLENOTE NOR ANY OWNER OF CONTENT WARRANTS THAT THE BOBBLENOTE IS FREE OF MALWARE OR OTHER HARMFUL COMPONENTS. IN ADDITION, BOBBLENOTE MAKES NO REPRESENTATION NOR DOES IT WARRANT, ENDORSE, GUARANTEE, OR ASSUME RESPONSIBILITY FOR ANY THIRD PARTY APPLICATIONS (OR THE CONTENT THEREOF), USER CONTENT, DEVICES OR ANY OTHER PRODUCT OR SERVICE ADVERTISED, PROMOTED OR OFFERED BY A THIRD PARTY ON OR THROUGH THE BOBBLENOTE SERVICE OR ANY HYPERLINKED WEBSITE, OR FEATURED IN ANY BANNER OR OTHER ADVERTISING AND BOBBLENOTE IS NOT RESPONSIBLE OR LIABLE FOR ANY TRANSACTION BETWEEN YOU AND THIRD PARTY PROVIDERS OF THE FOREGOING. NO ADVICE OR INFORMATION WHETHER ORAL OR IN WRITING OBTAINED BY YOU FROM BOBBLENOTE SHALL CREATE ANY WARRANTY ON BEHALF OF BOBBLENOTE WHILE USING THE BOBBLENOTE SERVICE.</b>
                        </div>
                        <div id="indemnify">
                            <h3>9. Indemnification</h3>
                            <b>You agree to indemnify and hold Bobblenote harmless from and against all damages, losses, and expenses of any kind (including reasonable attorney fees and costs) arising out of or related to:</b>
                            <br> <br>
                            <p>Your breach of the Agreements or any one of them</p>
                            <br>
                            <p>Any User Content you post or otherwise contribute</p>
                            <br>
                            <p>Any activity in which you engage on or through Bobblenote</p>
                            <br>
                            <p>Your violation of any law or the rights of a third party.</p>
                        </div>
                        <div id="arbitration">
                            <h3>10. Mandatory arbitration, severability and resolution</h3>
                            <b>You and Bobblenote agree that any dispute, claim, or controversy between you and Bobblenote arising in connection with or relating in any way to these Agreements or to your relationship with Bobblenote as a user of the Service (whether based in contract, tort, statute, fraud, misrepresentation, or any other legal theory, and whether the claims arise during or after the termination of the Agreements) will be determined by mandatory binding individual (not class) arbitration. You and Bobblenote further agree that the arbitrator shall have the exclusive power to rule on his or her own jurisdiction, including any objections with respect to the existence, scope or validity of the Arbitration Agreement or to the arbitrability of any claim or counterclaim. Arbitration is more informal than a lawsuit in court. THERE IS NO JUDGE OR JURY IN ARBITRATION, AND COURT REVIEW OF AN ARBITRATION AWARD IS LIMITED. There may be more limited discovery than in court. The arbitrator must follow this agreement and can award the same damages and relief as a court (including attorney fees), except that the arbitrator may not award any relief, including declaratory or injunctive relief, benefiting anyone but the parties to the arbitration. This arbitration provision will survive termination of the Agreements.</b>
                            <br> <br>
                            <p>Unless as otherwise stated in the Agreements, should any provision of the Agreements be held invalid or unenforceable for any reason or to any extent, such invalidity or enforceability shall not in any manner affect or render invalid or unenforceable the remaining provisions of the Agreements, and the application of that provision shall be enforced to the extent permitted by law.</p>
                        </div>
                        <div id="support">
                            <h3>11. Customer Support</h3>
                            <b>For customer support with account-related and payment-related questions ("Customer Support Queries"), please submit a ticket to our Customer Service department using the Customer Service contact form on the Contact Us section of our website. We will use reasonable endeavors to respond to all Customer Support Queries within a reasonable time frame but we make no promises that any Customer Support Queries will be responded to within any particular time frame and/or that we will be able to answer any such queries.</b>
                        </div>
                        <div id="contactus">
                            <h3>12. Contact Us</h3>
                            <b>If you have any questions concerning the Bobblenote Service or the Agreements, please contact Bobblenote Customer Service by visiting the Contact Us section of our website. Thank you for reading our Terms. We hope you enjoy Bobblenote!</b>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <?php include 'footer.php' ?>
     <!-- canvas menu  -->
     <div class="canvas-menu d-flex align-items-end flex-column">
        <button class="btn-close" aria-label="Close" type="button"></button>

        <div class="logo">
            <h1 style="font-family: 'Poetsen One', sans-serif;">Bobblenote</h1>
        </div>
        <nav>
            <ul class="vertical-menu">
                <li><a href="index.php">Home</a></li>
                <li>
                    <a href="#">Categories</a>
                    <ul class="submenu">
                    <?php
                        //snippet to select categories
                        $cat_query = "SELECT category FROM categories";
                        $cat_res = $connection->query($cat_query);
                        if ($cat_res) {
                            $cat_numrows = $cat_res->num_rows;
                            if ($cat_numrows >= 1) {
                                for ($i=0; $i < $cat_numrows; $i++) { 
                                    $cat_res->data_seek($i);
                                    $cat_data = $cat_res->fetch_array(MYSQLI_ASSOC);
                                    echo "<li>
                                    <a href='categories.php?cat=$cat_data[category]'>$cat_data[category]</a>
                                    </li>";
                                }
                            }
                        }
                    ?>
                    </ul>
                </li>
                <li><a href="competitions.php">Competitions</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php
                    if ($selector == "") {
                ?>
                <li><a href="login.php">Login</a></li>
                <li>
                    <a href="#" class="btn btn-default text-light">Sign up</a>
                </li>
                <?php
                    }
                ?>
            </ul>
        </nav>
    </div>


    <!-- search pop up  -->
    <div class="search-popup">
        <button class="btn-close" aria-label="Close" type="button"></button>

        <div class="search-content">
            <div class="text-center">
                <h3 class="mb-4 mt-0">Press ESC to close</h3>
            </div>

            <form action="" class="d-flex search-form">
                <div class="search-first w-100">
                <input type="search" id="mysearch" placeholder="Search tags, categories, post titles..." aria-label="Search"
                    class="form-control me-2">
                    <div id="res_card" class="card d-none" style="border:1px solid #b4b2b2;max-height: 300px;overflow-y: auto;">
                        <div class="list-group">
                        </div>
                    </div>
                </div>
                    <!-- <button class="search icon-button ms-1">
                        <i class="icon-magnifier"></i>
                    </button> -->
            </form>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="js/jquery.sticky-sidebar.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/general.js"></script>
</body>
</html>
