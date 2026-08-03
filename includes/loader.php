<style>
    .loader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(240, 242, 245, 0.92);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .loader-ball {
        width: 44px;
        height: 44px;
        border: 4px solid rgba(108, 92, 231, 0.15);
        border-top: 4px solid #6c5ce7;
        border-radius: 50%;
        animation: spin 0.8s cubic-bezier(0.4, 0, 0.2, 1) infinite;
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