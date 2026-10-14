<?php
require_once 'db/db_connect.php';
require_once 'php/php_class.php';

session_start();
if (empty($_SESSION['user_ID']) && empty($_SESSION['mun_code']) && empty($_SESSION['brgy'])) {
    header("Location: signin.php");
}

$mun_code = $_SESSION['mun_code'];
$brgy_code = $_SESSION['brgy_code'];
$brgy_session = $_SESSION['brgy'];
$mun_name = $_SESSION['mun_name'];
$user_ID = $_SESSION['user_ID'];
?>


<!doctype html>

<?php
include 'link/header_link.php';
?>

<body>


    <style>
        /* ---------- Theme: change these to restyle everything ---------- */
        :root {
            --cw-brand: #4a4a7d;
            --cw-brand-text: #ffffff;
            --cw-surface: #ffffff;
            --cw-text: #1f1f1f;
            --cw-muted: #6b6b6b;
            --cw-radius: 24px;
            --cw-width: 437px;
            --cw-height: 650px;
            --cw-offset: 20px;
            --cw-z: 2147483000;
            /* above almost everything; raise if something still covers it */
            --cw-font: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        body {
            margin: 0;
            font-family: var(--cw-font);
            background: #f5f6fa;
            min-height: 100vh;
        }

        /* ---------- Widget ---------- */
        .cw-panel {
            position: fixed;
            z-index: var(--cw-z);
            right: var(--cw-offset);
            bottom: 100px;
            width: min(var(--cw-width), calc(100vw - 2 * var(--cw-offset)));
            height: min(var(--cw-height), calc(100vh - 130px));
            background: var(--cw-brand);
            color: var(--cw-brand-text);
            border-radius: var(--cw-radius);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .18);
            font-family: var(--cw-font);
            transform-origin: bottom right;
            transition: opacity .2s ease, transform .2s ease, visibility .2s;
        }

        .cw-panel[hidden] {
            display: flex;
            opacity: 0;
            transform: scale(.92) translateY(12px);
            visibility: hidden;
            pointer-events: none;
        }

        .cw-views {
            flex: 1;
            position: relative;
            min-height: 0;
        }

        .cw-view {
            position: absolute;
            inset: 0;
            display: none;
            flex-direction: column;
        }

        .cw-view.active {
            display: flex;
        }

        /* Home view */
        .cw-home {
            padding: 90px 25px 0;
        }

        .cw-greeting {
            text-align: center;
            font-size: 19px;
            line-height: 1.5;
            margin: 0 0 40px;
            font-weight: 500;
        }

        .cw-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            width: 100%;
            box-sizing: border-box;
            padding: 20px 26px;
            background: var(--cw-surface);
            color: var(--cw-text);
            border: 0;
            border-radius: 14px;
            cursor: pointer;
            text-align: left;
            font: inherit;
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .cw-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(0, 0, 0, .18);
        }

        .cw-card-title {
            display: block;
            font-size: 18px;
            font-weight: 700;
        }

        .cw-card-sub {
            display: block;
            font-size: 15px;
            color: var(--cw-muted);
            margin-top: 4px;
        }

        .cw-card svg {
            flex: none;
            color: var(--cw-brand);
        }

        /* Chat view */
        .cw-chat-head {
            padding: 18px 22px;
            font-weight: 700;
            font-size: 17px;
            border-bottom: 1px solid rgba(255, 255, 255, .15);
        }

        .cw-messages {
            flex: 1;
            overflow-y: auto;
            padding: 18px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .cw-msg {
            max-width: 80%;
            padding: 10px 14px;
            border-radius: 16px;
            font-size: 15px;
            line-height: 1.4;
            word-wrap: break-word;
        }

        .cw-msg.agent {
            align-self: flex-start;
            background: var(--cw-surface);
            color: var(--cw-text);
            border-bottom-left-radius: 4px;
        }

        .cw-msg.visitor {
            align-self: flex-end;
            background: rgba(255, 255, 255, .2);
            border-bottom-right-radius: 4px;
        }

        .cw-composer {
            display: flex;
            gap: 8px;
            padding: 12px;
            background: rgba(0, 0, 0, .12);
        }

        .cw-composer input {
            flex: 1;
            border: 0;
            border-radius: 22px;
            padding: 12px 16px;
            font: inherit;
            font-size: 15px;
            background: var(--cw-surface);
            color: var(--cw-text);
            outline: none;
        }

        .cw-composer input:focus-visible {
            box-shadow: 0 0 0 2px rgba(255, 255, 255, .6);
        }

        .cw-send {
            flex: none;
            width: 44px;
            height: 44px;
            border: 0;
            border-radius: 50%;
            background: var(--cw-surface);
            color: var(--cw-brand);
            cursor: pointer;
            display: grid;
            place-items: center;
        }

        /* Bottom tab bar */
        .cw-tabs {
            display: flex;
            background: var(--cw-surface);
            height: 62px;
            flex: none;
        }

        .cw-tab {
            flex: 1;
            border: 0;
            background: none;
            cursor: pointer;
            display: grid;
            place-items: center;
            color: var(--cw-text);
        }

        .cw-tab.active {
            color: var(--cw-brand);
        }

        .cw-tab:focus-visible,
        .cw-card:focus-visible,
        .cw-send:focus-visible,
        .cw-launcher:focus-visible {
            outline: 3px solid #9b9bd6;
            outline-offset: -3px;
        }

        /* Launcher bubble */
        .cw-launcher {
            position: fixed;
            z-index: var(--cw-z);
            right: var(--cw-offset);
            bottom: var(--cw-offset);
            width: 76px;
            height: 76px;
            border: 0;
            border-radius: 50%;
            background: var(--cw-brand);
            color: var(--cw-brand-text);
            cursor: pointer;
            display: grid;
            place-items: center;
            box-shadow: 0 4px 16px rgba(0, 0, 0, .25);
        }

        .cw-launcher svg {
            transition: transform .2s ease;
        }

        .cw-launcher[aria-expanded="false"] svg {
            transform: rotate(180deg);
        }

        /* Optional badge */
        .cw-badge {
            position: fixed;
            z-index: var(--cw-z);
            right: 100px;
            bottom: 30px;
            background: rgba(255, 255, 255, .95);
            color: #555;
            font-size: 14px;
            padding: 8px 18px;
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .1);
            font-family: var(--cw-font);
        }

        .cw-badge[hidden] {
            display: none;
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                transition: none !important;
            }
        }
    </style>
    <div id="mytask-layout" class="theme-indigo">

        <?php include 'sidebar.php'; ?>


        <!-- main body area -->
        <div class="main px-lg-4 px-md-4">

            <?php include 'link/topbar.php'; ?>

            <?php
            $home = 'home';

            // if ($user_id == '1') {
            // $home = 'home';
            // } else {
            //   $home = 'incoming';
            // }
            $page = isset($_GET['page']) ? $_GET['page'] : $home;
            if (!file_exists($page . ".php")) {
                include '404.html';
            } else {
                include $page . '.php';
            }
            ?>

            <!-- Modal Members-->

        </div>
    </div>



</body>

<section class="cw-panel" id="cwPanel" role="dialog" aria-label="Live chat" hidden>
    <div class="cw-views">

        <div class="cw-view cw-home active" id="cwHome">
            <p class="cw-greeting">We are live and ready to chat with you now.<br>Say something to start a live chat.</p>
            <button class="cw-card" id="cwStart" type="button">
                <span>
                    <span class="cw-card-title">New Conversation</span>
                    <span class="cw-card-sub">We typically reply in a few minutes</span>
                </span>
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" stroke-linecap="round">
                    <path d="M22 2 11 13" />
                    <path d="M22 2 15 22l-4-9-9-4 20-7z" />
                </svg>
            </button>
        </div>

        <div class="cw-view" id="cwChat">
            <div class="cw-chat-head">Live chat</div>
            <div class="cw-messages" id="cwMessages" aria-live="polite"></div>
            <form class="cw-composer" id="cwForm" autocomplete="off">
                <input id="cwInput" type="text" placeholder="Type your message..." aria-label="Message">
                <button class="cw-send" type="submit" aria-label="Send">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" stroke-linecap="round">
                        <path d="M22 2 11 13" />
                        <path d="M22 2 15 22l-4-9-9-4 20-7z" />
                    </svg>
                </button>
            </form>
        </div>

    </div>

    <nav class="cw-tabs">
        <button class="cw-tab active" data-view="cwHome" aria-label="Home" type="button">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" stroke-linecap="round">
                <path d="M3 10.5 12 3l9 7.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z" />
            </svg>
        </button>
        <button class="cw-tab" data-view="cwChat" aria-label="Conversations" type="button">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" stroke-linecap="round">
                <path d="M4 5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H10l-5 4v-4a2 2 0 0 1-1-2z" />
            </svg>
        </button>
    </nav>
</section>

<span class="cw-badge" id="cwBadge">Powered by your brand</span>

<button class="cw-launcher" id="cwLauncher" type="button" aria-label="Toggle chat" aria-expanded="false" aria-controls="cwPanel">
    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m6 9 6 6 6-6" />
    </svg>
</button>


</html>

<?php
// include 'footer_script.php';
?>
<script>
    (function() {
        var panel = document.getElementById('cwPanel'),
            launcher = document.getElementById('cwLauncher'),
            badge = document.getElementById('cwBadge'),
            messages = document.getElementById('cwMessages'),
            form = document.getElementById('cwForm'),
            input = document.getElementById('cwInput'),
            tabs = panel.querySelectorAll('.cw-tab'),
            started = false;

        function setOpen(open) {
            panel.hidden = !open;
            launcher.setAttribute('aria-expanded', String(open));
            badge.hidden = !open;
            if (open && document.getElementById('cwChat').classList.contains('active')) input.focus();
        }

        function showView(id) {
            panel.querySelectorAll('.cw-view').forEach(function(v) {
                v.classList.toggle('active', v.id === id);
            });
            tabs.forEach(function(t) {
                t.classList.toggle('active', t.dataset.view === id);
            });
            if (id === 'cwChat') input.focus();
        }

        function addMessage(text, who) {
            var el = document.createElement('div');
            el.className = 'cw-msg ' + who;
            el.textContent = text; // textContent avoids HTML injection
            messages.appendChild(el);
            messages.scrollTop = messages.scrollHeight;
        }

        launcher.addEventListener('click', function() {
            setOpen(panel.hidden);
        });
        tabs.forEach(function(t) {
            t.addEventListener('click', function() {
                showView(t.dataset.view);
            });
        });

        document.getElementById('cwStart').addEventListener('click', function() {
            showView('cwChat');
            if (!started) {
                started = true;
                addMessage('Hi! How can we help you today?', 'agent');
            }
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            var text = input.value.trim();
            if (!text) return;
            addMessage(text, 'visitor');
            input.value = '';
            // TODO: send `text` to your backend / WebSocket here, then call addMessage(reply, 'agent')
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !panel.hidden) setOpen(false);
        });

        setOpen(false);
        // Expose a small API so your app can control the widget
        window.ChatWidget = {
            open: function() {
                setOpen(true);
            },
            close: function() {
                setOpen(false);
            },
            addMessage: addMessage
        };
    })();
    $(document).ready(function() {

        $(".delete_property").click(function() {
            let record_id = $(this).data("id");

            if (!confirm("Are you sure you want to delete this record?")) return;

            $.ajax({
                url: "ajax.php?action=delete_property",
                type: "POST",
                data: {
                    id: record_id
                },
                success: function(response) {
                    alert(response); // ✅ shows success/error message
                    location.reload(); // refresh table or remove row dynamically
                },
                error: function() {
                    alert("❌ AJAX error occurred");
                }
            });

        });

        $("#mun_code").change(function() {
            var property_municipality = $(this).val();
            if (property_municipality !== "") {
                $.ajax({
                    url: "php/get_barangay.php",
                    type: "POST",
                    data: {
                        mun_code: property_municipality
                    },
                    success: function(data) {
                        $("#brgy").html(data);
                    }
                });
            } else {
                $("#brgy").html('<option value="">-- Select Barangay --</option>');
            }
        });
    });
</script>