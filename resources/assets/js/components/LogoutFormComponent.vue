<template>
    <form :action="action" method="post">
        <input type="hidden" name="_token" :value="csrf">
        <button type="submit">Logout</button>
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