<style>
    .error-container {
        display: fixed;
        position: absolute;
        top: 10%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        color: var(--texto-cinza-escuro);
        border: 1px solid rgba(108, 92, 231, 0.15);
        border-radius: 0.8rem;
        padding: 2rem 1.5rem;
        text-align: center;
        box-shadow: 0 8px 32px rgba(108, 92, 231, 0.12);
        display: none;
        width: 80%;
        max-width: 400px;
        z-index: 1000;
        overflow: hidden;
        opacity: 0;
        animation: fadeIn 2s cubic-bezier(0.4, 0, 0.2, 1);

        & p {
            font-size: 1.5rem;
            margin: 0;
            padding: 0;
            font-weight: 500;
            color: #1e1e2e;
        }
    }

    .progress-bar {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%);
        width: 100%;
        animation: progress 2s linear;
        border-radius: 0 0 0.8rem 0.8rem;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translate(-50%, -60%);
        }

        5% {
            opacity: 1;
            transform: translate(-50%, -50%);
        }

        90% {
            opacity: 1;
            transform: translate(-50%, -50%);
        }

        100% {
            opacity: 0;
            transform: translate(-50%, -45%);
        }
    }

    @keyframes progress {
        0% {
            width: 100%;
        }

        100% {
            width: 0%;
        }
    }
</style>
<html>
<div class="error-container" id="error-container">
    <p><?= htmlspecialchars($_SESSION['resposta']) ?></p>
    <div class="progress-bar" id="progress-bar"></div>
</div>

<script defer>
    document.addEventListener('DOMContentLoaded', function() {
        var errorMessage = "<?php echo isset($_SESSION['resposta']) ? $_SESSION['resposta'] : ''; ?>";
        if (errorMessage !== '') {
            var errorContainer = document.getElementById('error-container');
            errorContainer.style.display = 'block';
            var timeoutId = setTimeout(function() {
                errorContainer.style.display = 'none';
                clearTimeout(timeoutId);
            }, 2000);

            document.addEventListener('click', cancelTimeout);

            function cancelTimeout() {
                clearTimeout(timeoutId);
                errorContainer.style.display = 'none';
                document.removeEventListener('click', cancelTimeout);
            }
        }
    });
</script>
<?php
unset($_SESSION['resposta']);
?>

</html>