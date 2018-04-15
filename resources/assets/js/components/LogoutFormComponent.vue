<template>
    <form :action="action" method="post">
        <input type="hidden" name="_token" :value="csrf">
        <div>
            <button type="submit">Logout</button>
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