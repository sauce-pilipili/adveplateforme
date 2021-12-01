function AjaxLength(cat,id) {
    $.ajax(
        {
            url: "",
            type: "GET",
            data: {
                'cat': cat,
            },
            success: function (data) {
                console.log(data.counter)
                let paragraphe = $("#lengthArticle"+id);
                if (data.counter === 0){
                    length = "Aucun article";
                }
                if (data.counter === 1){
                     length = data.counter + " article";
                 }
                if (data.counter > 1)
                 {
                     length = data.counter +" articles";
                 }
                paragraphe.append(length);
            }
        }
    )
}