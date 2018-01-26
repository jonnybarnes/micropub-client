<template>
    <form :action="action" method="post">
        <input type="hidden" name="_token" :value="csrf">
        <div>
            <label for="note">Note:</label>
            <textarea name="note" id="note"></textarea>
        </div>
        <div>
            <fieldset>
                <legend>Syndication</legend>
                <template v-for="target in targets">
                    <label :for="target.uid">{{ target.name }}:</label>
                    <input :id="target.uid" name="mp-syndicate-to[]" type="checkbox" :value="target.uid">
                </template>
            </fieldset>
        </div>
        <button type="submit" name="submit">Submit</button>
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
            },
            targets: {
                validator: function (value) {
                    return value[0].hasOwnProperty('uid')
                        && value[0].hasOwnProperty('name');
                },
                required: false,
            }
        }
    }
</script>
