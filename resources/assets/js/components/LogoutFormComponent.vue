<template>
    <form :action="action" method="post">
        <input type="hidden" name="_token" :value="csrf">
        <div class="control">
            <button type="submit" class="button is-outlined">Logout</button>
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