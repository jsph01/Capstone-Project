    var notABot = false;
    var GV_ANS = 0;
    function testRandom()
    {
        notABot = false;
        var n1 = Math.floor((Math.random() * 10) + 1);
        var n2 = Math.floor((Math.random() * 10) + 1);
        GV_ANS = n1 + n2;
        $("#divPrompt").show();
        $(txtMathQuiz).html("<br/><b>Prove you are human!</b><br/>What is " + n1 + " + " + n2 + "?");
        $("#mathQuizAns").val("");
        $("#quizMessage").html("");
        $("#mathQuizAns").focus();
    }
    function checkQuiz(fg)
    {
        if (fg === 1)
        {
            $("#divPrompt").hide();
            notABot = false;
            return;
        }
        var ans = parseInt($("#mathQuizAns").val());
        if (ans === GV_ANS)
        {
            notABot = true;
            $("#token").val('clean');

            $("#contactForm").submit();
        } else {
            $("#quizMessage").html("<font color='red'>Incorrect</font>");
            notABot = false;
        }
    }
    function validate(fields, names)
    {
        if (names===null)names=fields;
        var retval=new Array(fields.length);

        var ct=0;
        for (var i in fields)
        {
            
            var fld = fields[i];
            if ($("#"+fld).val()==="")
                retval[ct++]=names[i];
        }
        retval.length=ct;
        return retval;
    }