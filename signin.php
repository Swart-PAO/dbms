<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>AntiGo-RPT Login</title>
    <style>
        :root {
            --forest: #0f4d26;
            --leaf: #3fa535;
            --mint: #eaf5e6;
            --sky: #2f7fb5;
            --sand: #e8c48a;
            --ink: #16301f;
            --card: rgba(255, 255, 255, .92);
            --field: #fff;
            --line: #b9d8b2;
            --muted: #53705b;
            box-sizing: border-box;
            padding-top: env(safe-area-inset-top, 0px);
            padding-bottom: env(safe-area-inset-bottom, 0px);
        }

        @media (prefers-color-scheme:dark) {
            :root:not([data-theme="light"]) {
                --card: rgba(14, 38, 24, .92);
                --field: #102a1a;
                --line: #2f6a43;
                --ink: #e6f3e4;
                --muted: #9cc3a6
            }
        }

        :root[data-theme="dark"] {
            --card: rgba(14, 38, 24, .92);
            --field: #102a1a;
            --line: #2f6a43;
            --ink: #e6f3e4;
            --muted: #9cc3a6
        }

        * {
            box-sizing: border-box
        }

        html,
        body {
            height: 100%;
            margin: 0
        }

        body {
            font-family: "Trebuchet MS", "Segoe UI", system-ui, sans-serif;
            color: var(--ink);
            background: #dff0da;
            overflow-x: hidden
        }

        .sky {
            position: fixed;
            inset: 0;
            background: linear-gradient(180deg, #cfe9f5 0%, #e9f6e3 55%, #cfe8c6 100%);
            z-index: 0
        }

        .sun {
            position: absolute;
            top: 8%;
            right: 14%;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: radial-gradient(circle, #fff6d0 0 35%, rgba(255, 240, 170, .0) 70%);
            animation: pulse 6s ease-in-out infinite
        }

        .cloud {
            position: absolute;
            height: 34px;
            width: 110px;
            border-radius: 40px;
            background: #fff;
            opacity: .85;
            filter: blur(1px);
            animation: drift linear infinite
        }

        .cloud::before,
        .cloud::after {
            content: "";
            position: absolute;
            background: #fff;
            border-radius: 50%
        }

        .cloud::before {
            width: 50px;
            height: 50px;
            left: 16px;
            top: -24px
        }

        .cloud::after {
            width: 38px;
            height: 38px;
            left: 56px;
            top: -16px
        }

        .c1 {
            top: 12%;
            animation-duration: 70s
        }

        .c2 {
            top: 24%;
            transform: scale(.7);
            animation-duration: 95s;
            animation-delay: -40s
        }

        .c3 {
            top: 6%;
            transform: scale(.5);
            animation-duration: 55s;
            animation-delay: -20s
        }

        @keyframes drift {
            from {
                left: -160px
            }

            to {
                left: 110%
            }
        }

        @keyframes pulse {
            50% {
                transform: scale(1.15);
                opacity: .8
            }
        }

        .scene {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            height: 62vh;
            z-index: 1;
            pointer-events: none
        }

        .scene svg {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%
        }

        .sea {
            animation: sway 7s ease-in-out infinite
        }

        @keyframes sway {
            50% {
                transform: translateX(-14px)
            }
        }

        .win {
            animation: blink 4s steps(1) infinite
        }

        .win:nth-child(3n) {
            animation-delay: -1.3s
        }

        .win:nth-child(3n+1) {
            animation-delay: -2.6s
        }

        @keyframes blink {

            0%,
            70% {
                opacity: 1
            }

            80%,
            92% {
                opacity: .35
            }
        }

        .boat {
            animation: sail 38s linear infinite
        }

        @keyframes sail {
            from {
                transform: translateX(-120px)
            }

            to {
                transform: translateX(1500px)
            }
        }

        .leaf {
            position: fixed;
            top: -30px;
            width: 16px;
            height: 10px;
            background: var(--leaf);
            border-radius: 0 100% 0 100%;
            opacity: .7;
            z-index: 2;
            animation: fall linear infinite;
            pointer-events: none
        }

        @keyframes fall {
            to {
                transform: translate(80px, 110vh) rotate(540deg)
            }
        }

        /* floating property objects */
        .float {
            position: fixed;
            z-index: 2;
            pointer-events: none;
            animation: bob 5s ease-in-out infinite
        }

        .pin {
            left: 7%;
            top: 20%;
            animation-duration: 3s
        }

        .pin svg {
            filter: drop-shadow(0 8px 6px rgba(0, 0, 0, .25))
        }

        .pin .ring {
            position: absolute;
            left: 50%;
            bottom: -6px;
            width: 40px;
            height: 12px;
            margin-left: -20px;
            border: 3px solid rgba(220, 50, 50, .5);
            border-radius: 50%;
            animation: ripple 3s ease-out infinite
        }

        @keyframes bob {
            50% {
                transform: translateY(-18px)
            }
        }

        @keyframes ripple {
            from {
                transform: scale(.4);
                opacity: 1
            }

            to {
                transform: scale(2.2);
                opacity: 0
            }
        }

        .lens {
            left: 12%;
            bottom: 24%;
            animation: scan 14s ease-in-out infinite
        }

        @keyframes scan {

            0%,
            100% {
                transform: translate(0, 0) rotate(-8deg)
            }

            25% {
                transform: translate(120px, -30px) rotate(6deg)
            }

            50% {
                transform: translate(200px, 20px) rotate(-4deg)
            }

            75% {
                transform: translate(70px, 40px) rotate(8deg)
            }
        }

        .doc {
            right: 6%;
            top: 18%;
            animation-duration: 6.5s;
            animation-delay: -2s
        }

        /* layout */
        main {
            position: relative;
            z-index: 3;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px 16px
        }

        .card {
            width: min(500px, 100%);
            background: var(--card);
            backdrop-filter: blur(8px);
            border: 2px solid var(--forest);
            border-radius: 28px;
            padding: 28px 28px 22px;
            box-shadow: 0 24px 60px rgba(15, 77, 38, .28);
            animation: rise .9s cubic-bezier(.2, .9, .3, 1) both
        }

        @keyframes rise {
            from {
                opacity: 0;
                transform: translateY(40px) scale(.96)
            }
        }

        .brand {
            text-align: center;
            margin-bottom: 18px
        }

        .seal {
            width: 64px;
            height: 64px;
            margin: 0 auto 8px;
            border-radius: 50%;
            background: var(--forest);
            display: grid;
            place-items: center;
            animation: spin 20s linear infinite;
            box-shadow: 0 0 0 4px var(--mint), 0 0 0 6px var(--forest)
        }

        @keyframes spin {
            to {
                transform: rotate(360deg)
            }
        }

        h1 {
            margin: 0;
            font-size: 2.4rem;
            line-height: 1;
            font-weight: 900;
            letter-spacing: -.5px;
            color: var(--forest)
        }

        h1 b {
            color: var(--leaf)
        }

        :root[data-theme="dark"] h1,
        :root:not([data-theme="light"]) h1 {
            color: inherit
        }

        .sub {
            margin: 6px 0 0;
            font-size: .78rem;
            color: var(--muted);
            letter-spacing: .3px
        }

        .office {
            margin: 2px 0 0;
            font-size: .82rem;
            font-weight: 700;
            color: var(--forest)
        }

        label {
            display: block;
            font-size: .85rem;
            font-weight: 700;
            margin: 14px 0 6px
        }

        .fld {
            position: relative
        }

        .fld svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            stroke: var(--leaf);
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            pointer-events: none
        }

        input,
        select {
            width: 100%;
            height: 46px;
            border: 2px solid var(--line);
            border-radius: 14px;
            background: var(--field);
            color: var(--ink);
            font: inherit;
            padding: 0 14px 0 40px;
            transition: border-color .2s, box-shadow .2s
        }

        select {
            appearance: none;
            cursor: pointer;
            background-image: linear-gradient(45deg, transparent 50%, var(--leaf) 50%), linear-gradient(135deg, var(--leaf) 50%, transparent 50%);
            background-position: calc(100% - 20px) 20px, calc(100% - 14px) 20px;
            background-size: 6px 6px;
            background-repeat: no-repeat
        }

        select:disabled {
            opacity: .55;
            cursor: not-allowed
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: var(--leaf);
            box-shadow: 0 0 0 4px rgba(63, 165, 53, .25)
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px
        }

        @media (max-width:420px) {
            .row {
                grid-template-columns: 1fr
            }
        }

        .eye {
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
            background: none;
            width: 34px;
            height: 34px;
            cursor: pointer;
            border-radius: 50%
        }

        .eye svg {
            position: static;
            transform: none;
            stroke: var(--muted)
        }

        .eye:focus-visible {
            outline: 3px solid var(--leaf)
        }

        .btn {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 50px;
            margin-top: 20px;
            border: 0;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--leaf), var(--forest));
            color: #fff;
            font: inherit;
            font-weight: 800;
            font-size: 1rem;
            cursor: pointer;
            transition: transform .15s, box-shadow .2s;
            box-shadow: 0 8px 18px rgba(15, 77, 38, .35)
        }

        .btn::after {
            content: "";
            position: absolute;
            top: 0;
            left: -60%;
            width: 40%;
            height: 100%;
            background: linear-gradient(100deg, transparent, rgba(255, 255, 255, .45), transparent);
            animation: shine 3.5s ease-in-out infinite
        }

        @keyframes shine {
            to {
                left: 130%
            }
        }

        .btn:hover {
            transform: translateY(-2px)
        }

        .btn:active {
            transform: scale(.98)
        }

        .btn:focus-visible {
            outline: 3px solid var(--sky);
            outline-offset: 2px
        }

        .msg {
            min-height: 20px;
            margin: 12px 0 0;
            font-size: .85rem;
            text-align: center;
            font-weight: 700
        }

        .msg.err {
            color: #c0392b;
            animation: shake .4s
        }

        .msg.ok {
            color: var(--leaf)
        }

        @keyframes shake {
            25% {
                transform: translateX(-6px)
            }

            75% {
                transform: translateX(6px)
            }
        }

        .foot {
            margin-top: 10px;
            text-align: center;
            font-size: .72rem;
            color: var(--muted)
        }

        @media (max-width:760px) {

            .pin,
            .doc,
            .lens {
                display: none
            }

            .scene {
                height: 45vh
            }
        }

        @media (prefers-reduced-motion:reduce) {

            *,
            *::before,
            *::after {
                animation: none !important
            }
        }
    </style>
</head>

<?php
session_start();

require_once 'php/php_class.php';

$municipalities = getMunicipalities();

/*
|--------------------------------------------------------------------------
| Municipality Options
|--------------------------------------------------------------------------
*/
$municipalityOptions = '<option value="">Select Municipality</option>';

foreach ($municipalities as $mun) {
    $municipalityOptions .= sprintf(
        '<option value="%d">%s</option>',
        (int) $mun['mun_code'],
        htmlspecialchars(
            $mun['mun_name'],
            ENT_QUOTES,
            'UTF-8'
        )
    );
}

/*
|--------------------------------------------------------------------------
| Login Error
|--------------------------------------------------------------------------
*/
$loginError = '';

if (isset($_SESSION['error'])) {
    $loginError = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>


<body>


    <!-- =========================================================
     BACKGROUND
========================================================== -->

    <div class="sky" aria-hidden="true">
        <div class="sun"></div>
        <div class="cloud c1"></div>
        <div class="cloud c2"></div>
        <div class="cloud c3"></div>
    </div>

    <div class="scene" aria-hidden="true">

        <svg viewBox="0 0 1440 520" preserveAspectRatio="xMidYMax slice">

            <polygon
                points="0,380 220,160 380,300 560,120 800,330 1010,150 1230,300 1440,200 1440,520 0,520"
                fill="#6fae6a" />

            <polygon
                points="0,420 180,260 360,380 600,230 860,400 1100,250 1300,380 1440,300 1440,520 0,520"
                fill="#4c9a4c" />

            <g class="sea">
                <path
                    d="M900,430 Q1100,400 1500,420 L1500,520 L900,520Z"
                    fill="#4b8fbf"
                    opacity=".85" />
            </g>

            <g class="boat">
                <path d="M1000,432 h46 l-8 12 h-30z" fill="#7a4a24" />
                <path d="M1022,404 v28 l22,0z" fill="#fff" />
            </g>

            <rect x="640" y="250" width="110" height="200" fill="#e9eef2" />
            <rect x="660" y="230" width="70" height="230" fill="#2f6aa6" />

            <g fill="#bfe0f7">

                <rect class="win" x="668" y="246" width="14" height="14" />
                <rect class="win" x="690" y="246" width="14" height="14" />
                <rect class="win" x="712" y="246" width="12" height="14" />

                <rect class="win" x="668" y="274" width="14" height="14" />
                <rect class="win" x="690" y="274" width="14" height="14" />
                <rect class="win" x="712" y="274" width="12" height="14" />

                <rect class="win" x="668" y="302" width="14" height="14" />
                <rect class="win" x="690" y="302" width="14" height="14" />
                <rect class="win" x="712" y="302" width="12" height="14" />

                <rect class="win" x="668" y="330" width="14" height="14" />
                <rect class="win" x="690" y="330" width="14" height="14" />
                <rect class="win" x="712" y="330" width="12" height="14" />

                <rect class="win" x="668" y="358" width="14" height="14" />
                <rect class="win" x="690" y="358" width="14" height="14" />
                <rect class="win" x="712" y="358" width="12" height="14" />

            </g>

            <rect x="520" y="320" width="130" height="140" fill="#3fa535" />

            <g fill="#e6f5e0">
                <rect class="win" x="535" y="335" width="100" height="10" />
                <rect class="win" x="535" y="360" width="100" height="10" />
                <rect class="win" x="535" y="385" width="100" height="10" />
            </g>

            <rect x="750" y="300" width="70" height="160" fill="#dfe7ec" />

            <g fill="#2f6aa6">
                <rect class="win" x="762" y="316" width="16" height="14" />
                <rect class="win" x="790" y="316" width="16" height="14" />
                <rect class="win" x="762" y="346" width="16" height="14" />
                <rect class="win" x="790" y="346" width="16" height="14" />
            </g>

            <!-- House -->

            <rect x="860" y="380" width="150" height="90" fill="#f4f1e6" />
            <polygon points="845,382 935,320 1025,382" fill="#17803a" />

            <rect x="885" y="415" width="30" height="30" fill="#17803a" />
            <rect x="950" y="405" width="26" height="65" fill="#0f4d26" />

            <ellipse cx="840" cy="465" rx="38" ry="24" fill="#2f8a3a" />
            <ellipse cx="1030" cy="468" rx="34" ry="22" fill="#3a9a40" />

            <path
                d="M0,470 Q360,420 720,465 T1440,455 V520 H0Z"
                fill="#2c8a3a" />

            <path
                d="M0,500 Q400,455 780,495 T1440,485 V520 H0Z"
                fill="#0f4d26" />

        </svg>

    </div>


    <!-- =========================================================
     FLOATING OBJECTS
========================================================== -->

    <div class="float pin" aria-hidden="true">

        <svg width="62" height="86" viewBox="0 0 62 86">

            <path
                d="M31 2C15 2 3 14 3 30c0 20 28 52 28 52s28-32 28-52C59 14 47 2 31 2z"
                fill="#d93a3a" />

            <circle
                cx="31"
                cy="30"
                r="11"
                fill="#fff" />

        </svg>

        <span class="ring"></span>

    </div>


    <div class="float lens" aria-hidden="true">

        <svg width="120" height="130" viewBox="0 0 120 130">

            <circle
                cx="50"
                cy="50"
                r="42"
                fill="#cfe8c6"
                stroke="#1f3b4a"
                stroke-width="8" />

            <g stroke="#fff" stroke-width="2">

                <path d="M20 40h60" />
                <path d="M25 62h55" />
                <path d="M45 12v75" />
                <path d="M65 15v70" />

            </g>

            <rect
                x="36"
                y="38"
                width="26"
                height="20"
                fill="#e8c48a" />

            <line
                x1="82"
                y1="82"
                x2="112"
                y2="118"
                stroke="#1f3b4a"
                stroke-width="12"
                stroke-linecap="round" />

        </svg>

    </div>


    <div class="float doc" aria-hidden="true">

        <svg width="110" height="136" viewBox="0 0 110 136">

            <rect
                x="4"
                y="4"
                width="102"
                height="128"
                rx="10"
                fill="#fff"
                stroke="#17803a"
                stroke-width="6" />

            <path
                d="M55 18l20 16v16H35V34z"
                fill="#17803a" />

            <g
                stroke="#9bb8a0"
                stroke-width="5"
                stroke-linecap="round">

                <path d="M42 72h50" />
                <path d="M42 96h50" />
                <path d="M42 118h40" />

            </g>

            <g
                fill="none"
                stroke="#17803a"
                stroke-width="5"
                stroke-linecap="round">

                <path d="M16 70l6 6 10-12" />
                <path d="M16 94l6 6 10-12" />

            </g>

        </svg>

    </div>


    <!-- =========================================================
     LOGIN
========================================================== -->

    <main>

        <section class="card" aria-labelledby="t">

            <div class="brand">

                <div class="seal" aria-hidden="true">

                    <svg
                        width="34"
                        height="34"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="#fff"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round">

                        <path d="M3 11l9-8 9 8" />
                        <path d="M5 10v10h14V10" />
                        <path d="M10 20v-6h4v6" />

                    </svg>

                </div>

                <h1 id="t">
                    Anti<b>Go</b>-RPT
                </h1>

                <p class="sub">
                    Antique Integrated Government Operation – Real Property Tax
                </p>

                <p class="office">
                    Provincial Assessor’s Office
                </p>

            </div>


            <!-- =================================================
             IMPORTANT:
             This now submits to your REAL login.php
        ================================================== -->

            <form
                id="f"
                action="php/login.php"
                method="POST"
                novalidate>


                <!-- Username -->

                <label for="u">
                    Username
                </label>

                <div class="fld">

                    <svg viewBox="0 0 24 24">

                        <circle
                            cx="12"
                            cy="8"
                            r="4" />

                        <path
                            d="M4 21c0-4 4-6 8-6s8 2 8 6" />

                    </svg>

                    <input
                        id="u"
                        name="username"
                        type="text"
                        autocomplete="username"
                        placeholder="Enter your username"
                        required>

                </div>


                <!-- Password -->

                <label for="p">
                    Password
                </label>

                <div class="fld">

                    <svg viewBox="0 0 24 24">

                        <rect
                            x="4"
                            y="10"
                            width="16"
                            height="11"
                            rx="2" />

                        <path
                            d="M8 10V7a4 4 0 018 0v3" />

                    </svg>

                    <input
                        id="p"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        placeholder="Enter your password"
                        required>

                    <button
                        type="button"
                        class="eye"
                        id="eye"
                        aria-label="Show password">

                        <svg viewBox="0 0 24 24">

                            <path
                                d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z" />

                            <circle
                                cx="12"
                                cy="12"
                                r="3" />

                        </svg>

                    </button>

                </div>


                <!-- Municipality / Barangay -->

                <div class="row">

                    <div>

                        <label for="m">
                            Municipality
                        </label>

                        <div class="fld">

                            <svg viewBox="0 0 24 24">

                                <path
                                    d="M12 21s7-6 7-12a7 7 0 10-14 0c0 6 7 12 7 12z" />

                                <circle
                                    cx="12"
                                    cy="9"
                                    r="2.5" />

                            </svg>

                            <select
                                id="m"
                                name="mun_code"
                                required>

                                <?= $municipalityOptions ?>

                            </select>

                        </div>

                    </div>


                    <div>

                        <label for="b">
                            Barangay
                        </label>

                        <div class="fld">

                            <svg viewBox="0 0 24 24">

                                <path
                                    d="M3 11l9-8 9 8" />

                                <path
                                    d="M5 10v10h14V10" />

                            </svg>

                            <select
                                id="b"
                                name="brgy"
                                disabled
                                required>

                                <option value="">
                                    Select barangay
                                </option>

                            </select>

                        </div>

                    </div>

                </div>


                <!--
                Hidden fields required by your existing login.php
            -->

                <input
                    type="hidden"
                    name="mun_name"
                    id="mun_name">

                <input
                    type="hidden"
                    name="brgy_code"
                    id="brgy_code">


                <!-- Login error -->

                <?php if ($loginError !== ''): ?>

                    <p
                        class="msg err"
                        id="msg"
                        role="alert">

                        <?= htmlspecialchars(
                            $loginError,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>

                    </p>

                <?php else: ?>

                    <p
                        class="msg"
                        id="msg"
                        role="status"
                        aria-live="polite">
                    </p>

                <?php endif; ?>


                <!-- Submit -->

                <button
                    class="btn"
                    id="loginBtn"
                    type="submit">

                    Log in

                </button>

            </form>


            <p class="foot">
                Antique, Philippines
            </p>

        </section>

    </main>


    <!-- =========================================================
     JAVASCRIPT
========================================================== -->

    <script>
        const $ = id => document.getElementById(id);

        const municipality = $("m");
        const barangay = $("b");
        const munName = $("mun_name");
        const brgyCode = $("brgy_code");
        const message = $("msg");
        const form = $("f");
        const loginBtn = $("loginBtn");


        /*
        |--------------------------------------------------------------------------
        | Municipality Change
        |--------------------------------------------------------------------------
        */

        municipality.addEventListener("change", function() {

            const munCode = this.value;

            const selectedOption =
                this.options[this.selectedIndex];

            const selectedMunName =
                selectedOption ? selectedOption.text : "";

            /*
            |--------------------------------------------------------------------------
            | Store municipality name for login.php
            |--------------------------------------------------------------------------
            */

            munName.value = selectedMunName;


            /*
            |--------------------------------------------------------------------------
            | Reset barangay
            |--------------------------------------------------------------------------
            */

            barangay.innerHTML =
                '<option value="">Select barangay</option>';

            barangay.disabled = true;

            brgyCode.value = "";


            if (!munCode) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Load Barangays From Existing PHP
            |--------------------------------------------------------------------------
            */

            fetch("php/get_barangay.php", {

                    method: "POST",

                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },

                    body: "mun_code=" +
                        encodeURIComponent(munCode)

                })

                .then(response => {

                    if (!response.ok) {
                        throw new Error(
                            "Unable to load barangays."
                        );
                    }

                    return response.text();

                })

                .then(data => {

                    /*
                    |--------------------------------------------------------------------------
                    | get_barangay.php already returns <option> elements
                    |--------------------------------------------------------------------------
                    */

                    barangay.innerHTML =
                        data || '<option value="">No barangays found</option>';

                    barangay.disabled = false;

                })

                .catch(error => {

                    console.error(error);

                    barangay.innerHTML =
                        '<option value="">Unable to load barangays</option>';

                    barangay.disabled = true;

                });

        });


        /*
        |--------------------------------------------------------------------------
        | Barangay Change
        |--------------------------------------------------------------------------
        */

        barangay.addEventListener("change", function() {

            const selectedOption =
                this.options[this.selectedIndex];

            /*
            |--------------------------------------------------------------------------
            | Your existing get_barangay.php should generate:
            |
            | <option value="Barangay Name"
            |         data-brgy-code="1234">
            |     Barangay Name
            | </option>
            |--------------------------------------------------------------------------
            */

            brgyCode.value =
                selectedOption ?
                selectedOption.dataset.brgyCode || "" :
                "";

        });


        /*
        |--------------------------------------------------------------------------
        | Show / Hide Password
        |--------------------------------------------------------------------------
        */

        $("eye").addEventListener("click", function() {

            const password = $("p");

            const show =
                password.type === "password";

            password.type =
                show ? "text" : "password";

            this.setAttribute(
                "aria-label",
                show ?
                "Hide password" :
                "Show password"
            );

        });


        /*
        |--------------------------------------------------------------------------
        | Login Validation
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | We DO NOT preventDefault().
        |
        | The browser will submit normally to:
        |
        | php/login.php
        |
        |--------------------------------------------------------------------------
        */

        form.addEventListener("submit", function(e) {

            const username =
                $("u").value.trim();

            const password =
                $("p").value;

            const munCode =
                municipality.value;

            const brgyValue =
                barangay.value;

            if (
                !username ||
                !password ||
                !munCode ||
                !brgyValue ||
                !brgyCode.value
            ) {

                e.preventDefault();

                message.className =
                    "msg err";

                message.textContent =
                    "Please enter your username and password, then select a municipality and barangay.";

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Prevent double-click login
            |--------------------------------------------------------------------------
            */

            loginBtn.disabled = true;

            loginBtn.textContent =
                "Signing in...";

        });


        /*
        |--------------------------------------------------------------------------
        | Falling Leaves
        |--------------------------------------------------------------------------
        */

        for (let i = 0; i < 14; i++) {

            const leaf =
                document.createElement("i");

            leaf.className = "leaf";

            leaf.style.left =
                Math.random() * 100 + "vw";

            leaf.style.animationDuration =
                (12 + Math.random() * 14) + "s";

            leaf.style.animationDelay =
                (-Math.random() * 20) + "s";

            leaf.style.transform =
                "scale(" +
                (.6 + Math.random() * .9) +
                ")";

            document.body.appendChild(leaf);

        }
    </script>


</body>

</html>