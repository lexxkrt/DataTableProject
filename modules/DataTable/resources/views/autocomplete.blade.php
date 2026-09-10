<div x-data="{searchTerm:'',results:[]}">
    <input type="text"
           x-model="searchTerm">
    <div x-show="results.length > 0"
         class="list-group">
        <template x-for="result in results"
                  :key="result.id">
            <a href="#"
               class="list-group-item list-group-item-action"
               x-text="result.title"></a>
        </template>
    </div>
</div>