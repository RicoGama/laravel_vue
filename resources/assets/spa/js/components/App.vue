<template>
    <div id="app">
        <header>
        </header>
        <main>
            <router-view></router-view>
        </main>
        <footer class="page-footer">
            <div class="footer-copyright">
                <div class="container">
                    © {{ year }} <a href="#" class="grey-text text-lighten-4">Code Financeiro</a>
                </div>
            </div>
        </footer>
    </div>
</template>
<script type="text/javascript">
    export default {
        data() {
            return {
                year: new Date().getFullYear()
            }
        }
    };
</script>

<style type="text/css">
    #app {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
    }

    main {
        flex: 1 0 auto;
    }
</style>