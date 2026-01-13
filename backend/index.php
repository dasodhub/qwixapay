<?php
session_start();
require_once '../../locked/config/database.php';


if (!isset($_SESSION['csrf_token'])) {
    //RETURN BACK TO THE LOGIN PAGE
    $_SESSION['error'] = 'Unauthorized Access Denied';
    header('Location: ../login');
    exit();
}

//CHECK IF THE USER SESSION IS SET
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
    //RETURN BACK TO THE LOGIN PAGE
    $_SESSION['error'] = 'Access Denied';
    header('Location: ../../login');
    exit();
} else {


    $userId = $_SESSION['user_id'];
    $email = $_SESSION['email'];

    //SANITIZE THE DATAS AND MAKE SURE THE ARE REAL
    $userId = filter_var($userId, FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    //VALIDATE THE DATAS
    //VALIDATE THE USERID PASSED
    if (empty($userId) || strlen($userId) !== 6 || !is_numeric($userId)) {
        $_SESSION['error'] = 'Invalid User ID Passed';
        header('Location: ../../login');
        exit();
    }

    //NEXT VALIDATE THE EMAIL PASSED
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid Email Passed';
        header('Location: ../../login');
        exit();
    }


    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :userId AND email = :email");
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    //GET THE RESULT FROM THE DATABASE
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    //print_r($user);
}

//IF THE USER TYPE IS NOT SET TO STAFF OR ADMIN ... REDIRECT THE USER BACK TO THE RIGHT DASHBOARD
if ($user['profile_type'] !== 'Staff' && $user['profile_type'] !== 'Owner') {
    //RETURN BACK TO USERS DASHBOARD
    $_SESSION['message_type'] = 'error';
    $_SESSION['message'] = 'You are not authorized to access this page';
    header('Location: ../../user/');
    exit();
}

//IF THE USER IS NOT AVAILABLE REDIRECT BACK TO RELOGIN
if (!$user) {
    //REDIRECT BACK TO LOGIN PAGE
    header('Location: ../../login');
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Ebilite</title>
    <link rel="stylesheet" href="../../src/css/output.css">
    <link rel="stylesheet" href="../../src/css/input.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Toastr options
        toastr.options = {
            "closeButton": true,

            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        $(document).ready(function() {
            <?php if (isset($_SESSION["message_type"])): ?>
                toastr["<?php echo $_SESSION['message_type']; ?>"]("<?php echo $_SESSION['message']; ?>");
                <?php unset($_SESSION['message_type']); ?>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
        });
    </script>

</head>

<body class="bg-[#fff]">

    <div class="body-container w-full flex">
        <div
            class="sidebar fixed z-30 left-0 top-0 w-[20%] bg-white px-[38.5px] py-[60px] h-full overflow-y-scroll hidden lg:block">
            <div class="sidebar-details flex flex-col gap-[60px]">
                <div class="sidebar-header flex flex-col items-center gap-[19px]">
                    <div class="sidebar-logo flex items-center gap-[16px] justify-center">
                        <img src="../../assets/image/primary-logo.png" alt="logo">
                        <h1 class="text-[26px] font-[700]">Ebilite</h1>
                    </div>

                    <div class="user-level">
                        <p>User Position: <span> <?php echo htmlspecialchars($user['profile_type']); ?></span></p>
                    </div>
                </div>

                <div class="sidebar-nav flex-1">
                    <ul class="flex flex-col justify-between gap-[40px]">
                        <li>
                            <a href="../" class="flex items-center gap-[16px]">

                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li>
                            <small>Users</small>
                            <ul class="py-2 space-y-2">
                                <li>
                                    <a href="../user/"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">All
                                        Users</a>
                                </li>
                                <li>
                                    <a href="../user/customers"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Customers</a>
                                </li>
                                <li>
                                    <a href="../user/agents"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Agents</a>
                                </li>
                                <li>
                                    <a href="../user/staffs"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Staffs</a>
                                </li>
                                <li>
                                    <a href="../user/suspended"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Blocked/Suspended</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <small>Transactions</small>
                            <ul class="py-2 space-y-2">
                                <li>
                                    <a href="../transaction/"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">All
                                        Transactions</a>
                                </li>
                                <li>
                                    <a href="../transaction/success"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Successful
                                        Transactions</a>
                                </li>
                                <li>
                                    <a href="../transaction/pending"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Pending
                                        Transactions</a>
                                </li>
                                <li>
                                    <a href="../transaction/failed"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Failed
                                        Transactions</a>
                                </li>
                                <li>
                                    <a href="../transaction/history"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Withdrawable History</a>
                                </li>
                            </ul>
                        </li>


                        <li>
                            <small>Wallet</small>
                            <ul class="py-2 space-y-2">
                                <li>
                                    <a href="../wallet/"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Fund/Debit Wallet</a>
                                </li>
                                <li>
                                    <a href="../wallet/deposits"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Deposits</a>
                                </li>
                                <li>
                                    <a href="../wallet/transfer"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Transfers</a>
                                </li>
                                <li>
                                    <a href="../wallet/withdrawal"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Withdrawals</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <small>Service</small>
                            <ul class="py-2 space-y-2">
                                <li>
                                    <a href="./"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">All
                                        Services</a>
                                </li>
                                <li>
                                    <a href="./data-plans"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Data Plans
                                    </a>
                                </li>
                                <li>
                                    <a href="./tv"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">TV Plans
                                    </a>
                                </li>
                                <li>
                                    <a href="./data-plan-lookup"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Data Plan Lookup
                                    </a>
                                </li>
                                <li>
                                    <a href="./tv-plan-lookup"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">TV Plans Lookup
                                    </a>
                                </li>
                                <li>
                                    <a href="./exams"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Exams
                                    </a>
                                </li>

                                <li>
                                    <a href="./exams-lookup"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Exam Price Lookup
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <small>GiftCards</small>
                            <ul class="py-2 space-y-2">
                                <li>
                                    <a href="./"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">All GiftCards</a>
                                </li>
                                <li>
                                    <a href="./giftcard/add-giftcard"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Add GiftCard
                                    </a>
                                </li>


                            </ul>
                        </li>



                        <li>
                            <a href="../leaderboard/" class="flex items-center gap-[16px]">
                                <img src="../assets/icon/leaderboard.png" alt="">
                                <p>Leaderboard</p>
                            </a>
                        </li>
                        
                        <li>
                                <a href="../contest/" class="flex items-center gap-[16px]">
                                    <p>Contest</p>
                                </a>
                            </li>
                            
                            <li>
                                <a href="../pageant/" class="flex items-center gap-[16px]">
                                    <p>Pageant</p>
                                </a>
                            </li>

                            <li>
                                <a href="../events/" class="flex items-center gap-[16px]">
                                    <p>Events</p>
                                </a>
                            </li>


                        <li>
                            <small>Site Settings</small>
                            <ul class="py-2 space-y-2">
                                <li>
                                    <a href="../settings/"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">General Settings</a>
                                </li>
                                <li>
                                    <a href="../settings/fee"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Fees Settings</a>
                                </li>
                                <li>
                                    <a href="../setting/others"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Other Settings</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="../../user/" class="flex items-center gap-[16px]">

                                <p>Navigate to User Panel</p>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>

        <div class="main-body flex-1 lg:ml-[20%] w-[65%] flex flex-col items-center justify-center">
            <div
                class="main-header bg-white fixed lg:left-[20%] z-20 top-0 px-[18px] lg:px-[100px] py-[24px] w-full lg:max-w-[100%] border-b">
                <div class="main-content w-full lg:max-w-[80%] flex items-center justify-between">
                    <h1 class="text-[18px] md:text-[22px] font-semibold">Generate Coupon</h1>

                    <div class="norification flex items-center justify-center gap-[32px] lg:gap-[90px]">
                        <div class="user-profile flex items-center justify-center gap-[8px]">
                            <img src="../../assets/image/user-profile.png" alt="user-profile">
                            <div class="user-p hidden lg:block">
                                <p class="text-base font-semibold"><?php
                                                                    if (isset($user['firstname']) && isset($user['lastname'])) {
                                                                        echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']);
                                                                    } else {
                                                                        echo htmlspecialchars(strtoupper($user['username']));
                                                                    }

                                                                    ?></p>
                                <div class="profile-b w-[71px] h-[4px] bg-[#FFE102] rounded mx-auto"></div>
                            </div>
                        </div>
                        <div class="menu-header-icons flex gap-[24px]">
                            <img class="w-[25px]" src="../../assets/icon/bell.png" alt="bell">
                            <img class="w-[25px] lg:hidden" id="menu-bar" src="../../assets/icon/menu-icon.png" alt="menu">
                        </div>
                    </div>
                </div>
            </div>
            <div id="overlay" class="fixed z-40 inset-0 bg-black opacity-50 h-[100vh] hidden"></div>

            <div class="menu-nav bg-white w-[80%] h-[100vh] fixed top-0 z-50 left-0 lg:hidden overflow-y-scroll px-[24px] py-[36px] transform -translate-x-full transition-transform duration-300"
                id="mobile-nav">
                <div class="sidebar-details flex flex-col gap-[60px]">
                    <div class="sidebar-header flex flex-col items-start gap-[19px]">
                        <div class="sidebar-logo w-full flex items-center gap-[16px] justify-between">
                            <img src="../../assets/image/primary-logo.png" alt="logo">
                            <img class="w-[26px] cursor-pointer" id="close-menu" src="../../assets/icon/circle-xmark.png"
                                alt="Close Menu">
                        </div>

                        <div class="user-level">
                            <p>User Position: <span> <?php echo htmlspecialchars($user['profile_type']); ?></span></p>
                        </div>
                    </div>

                    <div class="sidebar-nav flex-1 mb-[60px]">
                        <ul class="flex flex-col justify-between gap-[40px]">
                            <li>
                                <a href="../" class="flex items-center gap-[16px]">

                                    <p>Dashboard</p>
                                </a>
                            </li>

                            <li>
                                <small>Users</small>
                                <ul class="py-2 space-y-2">
                                    <li>
                                        <a href="../user/"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">All
                                            Users</a>
                                    </li>
                                    <li>
                                        <a href="../user/customers"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Customers</a>
                                    </li>
                                    <li>
                                        <a href="../user/agents"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Agents</a>
                                    </li>
                                    <li>
                                        <a href="../user/staffs"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Staffs</a>
                                    </li>
                                    <li>
                                        <a href="../user/suspended"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Blocked/Suspended</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <small>Transactions</small>
                                <ul class="py-2 space-y-2">
                                    <li>
                                        <a href="../transaction/"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">All
                                            Transactions</a>
                                    </li>
                                    <li>
                                        <a href="../transaction/success"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Successful
                                            Transactions</a>
                                    </li>
                                    <li>
                                        <a href="../transaction/pending"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Pending
                                            Transactions</a>
                                    </li>
                                    <li>
                                        <a href="../transaction/failed"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Failed
                                            Transactions</a>
                                    </li>
                                    <li>
                                    <a href="../transaction/history"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Withdrawable History</a>
                                </li>
                                </ul>
                            </li>


                            <li>
                                <small>Wallet</small>
                                <ul class="py-2 space-y-2">
                                    <li>
                                        <a href="../wallet/"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Fund/Debit Wallet</a>
                                    </li>
                                    <li>
                                        <a href="../wallet/deposits"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Deposits</a>
                                    </li>
                                    <li>
                                        <a href="../wallet/transfer"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Transfers</a>
                                    </li>
                                    <li>
                                        <a href="../wallet/withdrawal"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Withdrawals</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <small>Service</small>
                                <ul class="py-2 space-y-2">
                                    <li>
                                        <a href="../services/"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">All
                                            Services</a>
                                    </li>
                                    <li>
                                        <a href="../services/data-plans"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Data Plans
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../services/tv"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">TV Plans
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../services/data-plan-lookup"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Data Plan Lookup
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../services/tv-plan-lookup"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">TV Plans Lookup
                                        </a>
                                    </li>
                                    <li>
                                        <a href="../services/exams"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Exams
                                        </a>
                                    </li>

                                    <li>
                                        <a href="../services/exams-lookup"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Exam Price Lookup
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <small>GiftCards</small>
                                <ul class="py-2 space-y-2">
                                    <li>
                                        <a href="./"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">All GiftCards</a>
                                    </li>
                                    <li>
                                        <a href="./giftcard/add-giftcard"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Add GiftCard
                                        </a>
                                    </li>


                                </ul>
                            </li>



                            <li>
                                <a href="../leaderboard/" class="flex items-center gap-[16px]">
                                    <img src="../assets/icon/leaderboard.png" alt="">
                                    <p>Leaderboard</p>
                                </a>
                            </li>
                            
                            <li>
                                <a href="../contest/" class="flex items-center gap-[16px]">
                                    <p>Contest</p>
                                </a>
                            </li>
                            
                            <li>
                                <a href="../pageant/" class="flex items-center gap-[16px]">
                                    <p>Pageant</p>
                                </a>
                            </li>

                            <li>
                                <a href="../events/" class="flex items-center gap-[16px]">
                                    <p>Events</p>
                                </a>
                            </li>


                            <li>
                                <small>Site Settings</small>
                                <ul class="py-2 space-y-2">
                                    <li>
                                        <a href="../settings/"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">General Settings</a>
                                    </li>
                                    <li>
                                        <a href="../settings/fee"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Fees Settings</a>
                                    </li>
                                    <li>
                                        <a href="../setting/others"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Other Settings</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="../../user/" class="flex items-center gap-[16px]">

                                    <p>Navigate to User Panel</p>
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>


            <div class="main-content mt-[80px] w-full">
                <div class="main-contents px-[18px] lg:px-[100px] py-[24px] w-full">
                    <div class="main-content w-full flex flex-col items-start justify-start gap-[30px]">
                        <div class="welcome-sec mt-[30px]">
                            <h2 class="text-[20px] font-semibold">Welcome, <?php echo htmlspecialchars($user['username']); ?> <span></span></h2>
                            <p>Manage Ambassador Applications</p>



                            <!-- Breadcrumb -->
                            <nav class="flex px-5 mt-[12px] py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                                    <li class="inline-flex items-center">
                                        <a href="../" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                            </svg>
                                            Home
                                        </a>
                                    </li>

                                    <li aria-current="page">
                                        <div class="flex items-center">
                                            <svg class="rtl:rotate-180  w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                            </svg>
                                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Manage Ambassadors</span>
                                        </div>
                                    </li>
                                </ol>
                            </nav>



                        </div>


                        <div class="w-full min-w-[100%] recent-transactions flex flex-col gap-[24px]">


                        </div>


                        <div class="w-full min-w-[100%] recent-transactions mb-[60px] flex flex-col gap-[24px]">
                            <div class="recent-transaction-title">
                                <h4 class="font-semibold text-[20px]">All Applicants</h4>
                            </div>

                            <div class="add-service border px-[12px] py-[24px] rounded-[12px]">

                                <div class="table-holder w-full max-w-[100%] border rounded-[12px] px-[12px] lg:px-[24px] py-[24px]">
                                    <?php
                                    // Get the current page number
                                    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

                                    // Set the number of items per page
                                    $itemsPerPage = 15;

                                    // Calculate the offset for the current page
                                    $offset = ($currentPage - 1) * $itemsPerPage;

                                    // Prepare the SQL query with pagination
                                    $stmt = $pdo->prepare("SELECT * FROM ambassadors ORDER by created_at DESC LIMIT :limit OFFSET :offset");
                                    $stmt->bindParam(':limit', $itemsPerPage, PDO::PARAM_INT);
                                    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                                    $stmt->execute();
                                    $ambassadors = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    // Get the total number of ambassadors
                                    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM ambassadors");
                                    $stmt->execute();
                                    $totalAmbassadors = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

                                    // Calculate the total number of pages
                                    $totalPages = ceil($totalAmbassadors / $itemsPerPage);

                                    if ($totalAmbassadors == 0) { ?>
                                        <p class="text-center text-gray-500">No ambassadors available now.</p>
                                    <?php } else { ?>
                                        <div class="relative w-full overflow-x-auto sm:rounded-lg">
                                            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3">FirstName</th>
                                                        <th scope="col" class="px-6 py-3">LastName</th>
                                                        <th scope="col" class="px-6 py-3">School</th>
                                                        <th scope="col" class="px-6 py-3">Level</th>
                                                        <th scope="col" class="px-6 py-3">Phone</th>
                                                        <th scope="col" class="px-6 py-3">Photo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($ambassadors as $ambassador) {

                                                    ?>

                                                        <tr class="bg-white border-b hover:bg-gray-50">
                                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                                <?php echo htmlspecialchars($ambassador['first_name']); ?>

                                                            </th>

                                                            <td class="px-6 py-4">
                                                                <?php echo htmlspecialchars($ambassador['last_name']); ?>
                                                            </td>

                                                            <td class="px-6 py-4 font-semibold">
                                                                <?php echo htmlspecialchars($ambassador['school']); ?>
                                                                <br>
                                                            </td>

                                                            <td class="px-6 py-4">
                                                                <?php echo htmlspecialchars($ambassador['level']); ?>
                                                            </td>

                                                            <td class="px-6 py-4">
                                                                <?php echo htmlspecialchars($ambassador['phone']); ?>
                                                            </td>

                                                            <td class="px-6 py-4">
                                                                <img src="https://zonixx.ng/ambassador/uploads/<?php echo htmlspecialchars($ambassador['photo']); ?>" alt="Profile Photo" class="w-12 h-12 rounded-full">
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Pagination links -->
                                        <div class="flex justify-center mt-4 space-x-2">
                                            <?php if ($currentPage > 1) { ?>
                                                <a href="?page=<?php echo $currentPage - 1; ?>" class="px-4 py-2 text-[#ffe102] bg-gray-100 rounded hover:bg-gray-200">Previous</a>
                                            <?php } ?>
                                            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                                <a href="?page=<?php echo $i; ?>" class="px-4 py-2 text-[#ffe102] bg-gray-100 rounded hover:bg-gray-200 <?php if ($i == $currentPage) {
                                                                                                                                                            echo 'bg-[#ffe102] text-gray-900 font-bold';
                                                                                                                                                        } ?>"><?php echo $i; ?></a>
                                            <?php } ?>
                                            <?php if ($currentPage < $totalPages) { ?>
                                                <a href="?page=<?php echo $currentPage + 1; ?>" class="px-4 py-2 text-[#ffe102] bg-gray-100 rounded hover:bg-gray-200">Next</a>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>

                            </div>


                        </div>


                    </div>
                </div>

            </div>

            <div class="main-footer fixed bg-[#fff] bottom-0 px-[18px] lg:px-[100px] py-[24px] w-full border-t">

            </div>

        </div>
    </div>

    <script>
        document.getElementById('menu-bar').addEventListener('click', function() {
            document.getElementById('mobile-nav').classList.remove('-translate-x-full');
            document.getElementById('overlay').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent body scroll
        });

        document.getElementById('close-menu').addEventListener('click', function() {
            document.getElementById('mobile-nav').classList.add('-translate-x-full');
            document.getElementById('overlay').classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore body scroll
        });

        document.getElementById('overlay').addEventListener('click', function() {
            document.getElementById('mobile-nav').classList.add('-translate-x-full');
            document.getElementById('overlay').classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore body scroll
        });
    </script>




    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="../../src/js/main.js"></script>
</body>

</html>