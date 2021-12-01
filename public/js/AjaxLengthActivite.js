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
                    length = data.counter +" activité";
                }
                if (data.counter === 1){
                    length = data.counter + " activité";
                }
                if (data.counter > 1)
                {
                    length = data.counter +" activités";
                }
                paragraphe.append(length);
            }
        }
    )
}