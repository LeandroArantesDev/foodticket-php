<style>
    .loader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .loader-ball {
        width: 48px;
        height: 48px;
        border: 6px solid var(--azul);
        border-top: 6px solid var(--branco);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>
<div class="loader-overlay" id="loader">
    <div class="loader-ball"></div>
</div>
<script>
    document.onreadystatechange = function() {
        const loader = document.getElementById('loader');
        if (document.readyState !== "complete") {
            loader.style.display = "flex";
        } else {
            loader.style.display = "none";
        }
    };
</script>