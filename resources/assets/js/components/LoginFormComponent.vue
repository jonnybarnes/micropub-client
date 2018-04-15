<template>
    <form :action="action" method="post">
        <input type="hidden" name="_token" :value="csrf">
        <div>
            <label for="me">Homepage:</label>
            <input type="url" name="me" id="me">
        </div>
        <div>
            <label for="remember">Remember Me:</label>
            <input type="checkbox" name="remember" id="remember">
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>
</template>
<script>
    module.exports = {
        props: {
            action: {
                type: String,
                required: true,
            },
            csrf: {
                type: String,
                required: true,
            }
        }
    }
</script>