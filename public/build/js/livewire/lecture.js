function SortQuestionsDivs(parentID, grand_parent_div_id, ParentCount, DeleteclassName)
{
    var ParentObject = checkCountForSortQuestionsDivs(parentID, ParentCount);      
    // console.log(ParentObject);

    var count = ParentObject.count;
    var parentID = ParentObject.parentID;   // 'questionDiv1'  1  => questionDiv  || questionDivFirst1 => questionDivFirst || questionDivSecond1 => questionDivSecond || questionDivThird1 => questionDivThird
    var parentID1 = parentID+'1';           //questionDiv1  || questionDivFirst1 || questionDivSecond1 || questionDivThird1
    var parentID2 = parentID+'2';           //questionDiv2  || questionDivFirst2 || questionDivSecond2 || questionDivThird2
    var parentID3 = parentID+'3';           //questionDiv3  || questionDivFirst3 || questionDivSecond3 || questionDivThird3

    var issetparentID = $('div[id^=' + parentID + ']');       // get questionDiv,
    var issetparentID1 = $('div[id^=' + parentID1 + ']');     // get questionDiv1,  
    var issetparentID2 = $('div[id^=' + parentID2 + ']');     // get questionDiv2,
    var issetparentID3 = $('div[id^=' + parentID3 + ']');     // get questionDiv3,

    if (count == 3 && issetparentID.length && issetparentID1.length && issetparentID3.length) 
    {
        issetparentID3.attr('id', parentID2); 
        issetparentID3.find('.' + DeleteclassName).css('display', 'block').attr('data-parent_id', parentID2).attr('data-grand-parent_id', grand_parent_div_id);

        if(DeleteclassName == 'deleteAssessment')
        {
            issetparentID3.find('.ChildOfParent').attr('data-parent_id', parentID2);
        }
    }
    else if (count == 3 && issetparentID.length && issetparentID2.length && issetparentID3.length) 
    {
        issetparentID2.attr('id', parentID1); 
        issetparentID2.find('.' + DeleteclassName).css('display', 'block').attr('data-parent_id', parentID1).attr('data-grand-parent_id', grand_parent_div_id);
        
        issetparentID3.attr('id', parentID2); 
        issetparentID3.find('.' + DeleteclassName).css('display', 'block').attr('data-parent_id', parentID2).attr('data-grand-parent_id', grand_parent_div_id);

        if(DeleteclassName == 'deleteAssessment')
        {
            issetparentID2.find('.ChildOfParent').attr('data-parent_id', parentID1);
            issetparentID3.find('.ChildOfParent').attr('data-parent_id', parentID2);
        }
    }
    else if(count == 2 && issetparentID.length && issetparentID2.length) 
    {
        issetparentID2.attr('id', parentID1); 
        issetparentID2.find('.' + DeleteclassName).css('display', 'block').attr('data-parent_id', parentID1).attr('data-grand-parent_id', grand_parent_div_id);

        if(DeleteclassName == 'deleteAssessment')
        {
            issetparentID2.find('.ChildOfParent').attr('data-parent_id', parentID1);

        }
    }
}
function checkCountForSortQuestionsDivs(parentID, ParentCount)
{
    var count = 0;
    var parentID = GetParentID(parentID, ParentCount);   // 2  questionDivFirst1   questionDivFirst

    if ($('div[id^=' + parentID + ']').length)    // questionDiv   ||  questionDivFirst   || questionDivSecond  || questionDivThird
    {
        count++;
    }
    
    var NewparentID = parentID+'1';
    
    if ($('div[id^=' + NewparentID + ']').length)   // questionDiv1   ||  questionDivFirst1   || questionDivSecond1  || questionDivThird1
    {
        count++;
    }
    
    var NewparentID = parentID+'2';
    
    if ($('div[id^=' + NewparentID + ']').length)    //// questionDiv2   ||  questionDivFirst2  || questionDivSecond2  || questionDivThird2
    {
        count++;
    }
    
    var NewparentID = parentID+'3';
    
    if ($('div[id^=' + NewparentID + ']').length)   //// questionDiv3   ||  questionDivFirst3  || questionDivSecond3  || questionDivThird3
    {
        count++;
    }
   
    return {count, parentID};
}
function GetParentID(parentID, ParentCount)
{

    if(ParentCount == 1)                                        // AssessmentDiv
    {
        index = parentID.indexOf("Div");                        //questionDiv1
        return parentID.substring(0, index + 3);            //questionDiv
    }
    else if(ParentCount == 2)                                   // AssessmentDiv1
    {               
        index = parentID.indexOf("DivFirst");                   //questionDivFirst1
        return parentID.substring(0, index + 8);            //questionDivFirst
    }
    
    else if(ParentCount == 3)                                   // AssessmentDiv2
    {
        index = parentID.indexOf("DivSecond");                  //questionDivSecond1
        return parentID.substring(0, index + 9);            //questionDivSecond
    }

    else if(ParentCount == 4)                                   // AssessmentDiv3
    {
        index = parentID.indexOf("DivThird");                   //questionDivThird1
        return parentID.substring(0, index + 8);            //questionDivThird
    }
}
function RemoveDuplicationForAddQuestion(questionDivClone, DivID, LevelID)
{
    for (var i = 0; i <= 3; i++) 
    {
        var selector = (i === 0) ? '#' + 'RadioAnswer' + DivID : '#' + 'RadioAnswer' + i + DivID;
        RadioClone = questionDivClone.find(selector);
        RadioClone.attr('id', 'RadioAnswer' + DivID + LevelID);
        RadioClone.attr('name', 'RadioAnswer' + DivID + LevelID);
    }           
}
function GetFinalData()
{
    LectureAssessmentData = {};
    Validation = false;
    
    var K=0;
   
    if($('#AssessmentButton').css('display') === 'none')
    {        
        
    
        Swal.fire({
            icon: 'error', 
            title: 'Oops...',
            text: 'Please enter passing % for this lecture',
        });
        Validation= true;
        return;
    }

    $('[id^="AssessmentDiv"]').each(function(i) 
    {
        K++;
        var Parent = $(this);
        LectureAssessmentData[i+1] = {};
        var l=0;

        Parent.find('[id^="questionDiv"]').each(function(j) 
        {

            l++;

            var Child = $(this);
            
            var childData = {};
            question = Child.find('#question').val();
            // console.log(typeof question)  // string
            
            if (question !== null && question !== undefined && question.trim() !== '') 
            {
                childData.question = question;
            }
            else
            {
                Swal.fire({
                    icon: 'error', 
                    title: 'Oops...',
                    text: 'Please Enter Question ' + l + ' For ' + 'Assessment ' + K,
                });
                Validation= true;
                return;
            }
            
            let selectedRadio = Child.find('input[type="radio"]:checked');

            if (selectedRadio.length > 0) 
            {
                childData.correctAnswer = selectedRadio.filter(':checked').val();
            }
            else
            {
                Swal.fire({
                    icon: 'error', 
                    title: 'Oops...',
                    text: 'Please Select Correct Answer for: Question ' + l + ' Of Assessment ' + K,
                });
                
                Validation= true;
                return;
            }
                
            for (var m = 1; m <= 4; m++) 
            {
                ChildQuestionAnswer = Child.find('#Answer' + m).val();
                // console.log(ChildQuestionAnswer);

                if (ChildQuestionAnswer !== null && ChildQuestionAnswer !== undefined && ChildQuestionAnswer.trim() !== '') 
                {
                    childData['Answer' + m] = ChildQuestionAnswer; 
                }
                else
                {
                    Swal.fire({
                        icon: 'error', 
                        title: 'Oops...',
                        text: 'Please Enter Answer ' + m + ' For Question ' + l + ' For ' + 'Assessment ' + K,
                    });
                    Validation= true;
                    break; 
                }
            }
            LectureAssessmentData[i+1][j+1] = childData;
            j=0;
        });
        
        var occurrenceDuration = Parent.find('#occurrence_duration').val();

        if (occurrenceDuration) 
        {
            LectureAssessmentData[i + 1]['occurrence_duration'] = occurrenceDuration;
        }
        else
        {
            Validation= true;
            Swal.fire({
                icon: 'error', 
                title: 'Oops...',
                text: 'Please Enter Duration To Occur for ' + 'Assessment ' + K,
            });
        }

        if(Validation)
        {
            return;
        }
    });

    i=0;
    if(Validation)
    {
        return false;
    }

    return LectureAssessmentData;
}
function GetAssessmentOccuranceTime(first=false, AssessmentDivID='')
{
    if(first)
    {
        // let RemoveDigitFromTheLast = ParentID.replace(/Div\d+$/, "Div");          // remove last digit
        let assessmentDiv  = $('div[id^=' + AssessmentDivID + ']');                                          // get assessmentDiv,
        const AssessmentDivIDTime = assessmentDiv.find('.occurrence_duration').val();
        return parseInt(AssessmentDivIDTime.replace(/\D+/g, ""));
    }
    else
    {
        let assessmentDivName  =  AssessmentDivID.replace(/Div(\d)$/, function(match, capturedDigit)   // minus 1 with last digit 
        {
            return "Div" + (parseInt(capturedDigit) - 1);
        });

        let assessmentDiv  = $('div[id^=' + assessmentDivName + ']');                                          // get assessmentDiv,
        const AssessmentDivIDTime = assessmentDiv.find('.occurrence_duration').val();
        return parseInt(AssessmentDivIDTime.replace(/\D+/g, ""));
    }
}
function CheckOccurrencesDuration()
{
    var times = {};

    ParentIDLevel=0;
    $('[id^="AssessmentDiv"]').map(function() 
    {
        return ParentIDLevel++;
    }).get();

    // for (let i = 2; i <= ParentIDLevel; i++) 
    //     {
    //         const divIdentifier = "AssessmentDiv" + (i === 2 ? '' : i - 1);              // Adjust the div identifier based on the current iteration
    //         times["ParentTime" + i] = GetAssessmentOccuranceTime(i === 2, divIdentifier);
        
    //     }
    // console.log(times);

    // console.log('CheckOccurrencesDuration');

    if(ParentIDLevel == 2)
    {                
        times.FirstParentTime = GetAssessmentOccuranceTime(true, "AssessmentDiv");                          // make AssessmentDiv3 to assessmentDiv and get assessmentDiv,  
        times.SecondParentTime = GetAssessmentOccuranceTime(false, "AssessmentDiv"+(ParentIDLevel));      // make assessmentDiv2 to assessmentDiv1 by minus 1 with the last digit after div                  
    }
    else if(ParentIDLevel == 3)
    {
        times.FirstParentTime = GetAssessmentOccuranceTime(true, "AssessmentDiv");                          // make AssessmentDiv3 to assessmentDiv and get assessmentDiv,  
        times.SecondParentTime = GetAssessmentOccuranceTime(false, "AssessmentDiv"+(ParentIDLevel-1));      // make assessmentDiv2 to assessmentDiv1 by minus 1 with the last digit after div                  
        times.ThirdParentTime = GetAssessmentOccuranceTime(false, ("AssessmentDiv"+ParentIDLevel));       // make assessmentDiv3 to assessmentDiv2 by minus 1 with the last digit after div                        
    }
    else if(ParentIDLevel == 4)
    {
        times.FirstParentTime = GetAssessmentOccuranceTime(true, "AssessmentDiv");                                 // make AssessmentDiv3 to assessmentDiv and get assessmentDiv,  
        times.SecondParentTime = GetAssessmentOccuranceTime(false, "AssessmentDiv"+(ParentIDLevel-2));  // make assessmentDiv2 to assessmentDiv1 by minus 1 with the last digit after div                  
        times.ThirdParentTime = GetAssessmentOccuranceTime(false, "AssessmentDiv"+(ParentIDLevel-1));       // make assessmentDiv3 to assessmentDiv2 by minus 1 with the last digit after div                  
        times.ForthParentTime = GetAssessmentOccuranceTime(false, ("AssessmentDiv"+(ParentIDLevel)));       // make assessmentDiv4 to assessmentDiv3 by minus 1 with the last digit after div                  
    }
    return ValidateAssessmentsDurationTime(times);
}
function ValidateAssessmentsDurationTime(times)
{
    
    if(CheckIfAnyFieldEmpty(times))
    {
        if (times.hasOwnProperty('SecondParentTime')) 
        {
            if (times.FirstParentTime >= times.SecondParentTime)
            {
                showErrorPopUp(null, "Second Assessment Time: " + times.SecondParentTime + " Should Be Greater Then First Asessment's Time: " + times.FirstParentTime);
                return false;
            }
        }
        if (times.hasOwnProperty('ThirdParentTime')) 
        {
            if(CheckIfAnyFieldEmpty(times))
            {        
                if(times.SecondParentTime >= times.ThirdParentTime)
                {
                    showErrorPopUp(null, "Third Assessment Time: " + times.ThirdParentTime + " Should Be Greater Then Second Asessment's Time: " + times.SecondParentTime);
                    return false;
                }
            }
        }
        if (times.hasOwnProperty('ForthParentTime')) 
        {
            if (times.ThirdParentTime >= times.ForthParentTime)
            {
                showErrorPopUp(null, "Forth Assessment Time: " + times.ForthParentTime + " Should Be Greater Then Third Asessment's Time: " + times.ThirdParentTime);
                return false;
            }   
        }
    }
    else
    {
        return false;
    }
}
function CheckIfAnyFieldEmpty(times)
{
    if(typeof times.FirstParentTime === 'number' && isNaN(times.FirstParentTime))
    {
        showErrorPopUp(null, "Please Insert Time For First Asssessment");
        return false;
    }
    else if(typeof times.SecondParentTime === 'number' && isNaN(times.SecondParentTime))
    {
        showErrorPopUp(null, "Please Insert Time For Second Asssessment");
        return false;
    }
    else if(typeof times.ThirdParentTime === 'number' && isNaN(times.ThirdParentTime))
    {
        showErrorPopUp(null, "Please Insert Time For Third Asssessment");
        return false;
    }
    else if(typeof times.ForthParentTime === 'number' && isNaN(times.ForthParentTime))
    {
        showErrorPopUp(null, "Please Insert Time For Forth Asssessment");
        return false;
    }
    return true;
}
function UpdateHiddenStatusOfAssessmentDivs()
{       
   

    var OnloadOccurrence_duration = $('#AssessmentDiv').find('#occurrence_duration').val();
    if (!isNaN(parseInt(OnloadOccurrence_duration, 10))) 
    {
        let noAssessmentButton = $('#noAssessmentButton');
        if(noAssessmentButton.length)
        {
            ValidateAssessmentForm=false;
            noAssessmentButton.css('display', 'block');     //show No assessment form button
            $('#AssessmentButton').css('display', 'none');  //hide show assessment form button
            $('.AddAssessment').css('display', 'block');    //show Add assessment form button
        }
    }  

}
function UpdateShowOrHideAsessments(StatusValue, Button)
{
    // $('#passing_ratio_id').css('display', StatusValue ? 'none' : 'block');

    ValidateAssessmentForm = StatusValue;
    Button.css('display', 'none');
    console.log(ValidateAssessmentForm);
    ChangeDisplayOfAllAssessmentDivs(ValidateAssessmentForm === true ? 'none' : 'block');
    $('.AddAssessment').css('display', ValidateAssessmentForm === true ? 'none' : 'block');
    $(ValidateAssessmentForm ? '#AssessmentButton' : '#noAssessmentButton').css('display', 'block');
}
function ChangeDisplayOfAllAssessmentDivs(DisplayValue)
{
    $('[id^="AssessmentDiv"]').each(function(i) 
    {
        var Parent = $(this);
        Parent.css('display', DisplayValue);
    });
}

