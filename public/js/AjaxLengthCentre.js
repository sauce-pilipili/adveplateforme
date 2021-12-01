function AjaxLengthCentre(cat,id) {
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
                    length = data.counter +" centre";
                }
                if (data.counter === 1){
                    length = data.counter + " centre";
                }
                if (data.counter > 1)
                {
                    length = data.counter +" centres";
                }
                paragraphe.append(length);
            }
        }
    )
}