<div x-data="toast()" @notify.window="show($event.detail)" class="fixed top-5 right-5 z-[9999] space-y-3">

    <template x-for="item in items" :key="item.id">
        <div x-transition class="px-4 py-3 rounded-xl shadow text-white" :class="{
                'bg-green-600': item.type === 'created',
                'bg-blue-600': item.type === 'updated',
                'bg-red-600': item.type === 'deleted'
            }">
            <span x-text="item.message"></span>
        </div>
    </template>

</div>

<script>
    function toast() {
        return {
            items: [],
            show(detail) {
                const id = Date.now();
                this.items.push({ id, ...detail });

                setTimeout(() => {
                    this.items = this.items.filter(i => i.id !== id);
                }, 3500);
            }
        }
    }
</script>
