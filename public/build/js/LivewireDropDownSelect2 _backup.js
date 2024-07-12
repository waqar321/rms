
            
        // -----------------------------------------flow-----------------
        // 1- on component ready, emit an event "pageLoaded" from view that emit back the event "loadDropDownData" from controller, => page ready
        // 2- then emit from controler to "loadDropDownData" and emit from view "LoadDataNow" to get data,        => ready to load
        // 3- event "LoadDataNow" loads the data, emit back the event "loadedDataExcepEmployee" from controller,  => data loaded
        // 4- then emit again the event "LoadEmployeeNowCount" from view to get recor counts,                     => get labels 
        // 5- then event "loadedEmployeeDataCount" set's the labels of counts & apply select2 to all records      => place labels
        // 6- apply exceptional select2 to employees because the data is huge,                                    => employee reloaded      
        // 7 -   

 
        $(document).on('click', '#SendFormRequest', function(event) 
        {
            event.preventDefault();

            if($(this).attr('data-component') == 'SendNotification')
            {
                if(ValidateElements($(this).attr('data-component')))
                {
                    Livewire.emit('sendNotificationEvent');
                }
                else
                {
    
                    Swal.fire({
                        icon: 'error', 
                        title: 'Oops...',
                        text: 'Title and body is must required',
                    });
                }
            }
            else if($(this).attr('data-component') == 'SendCourseAlignment')
            {
                ValidateElements($(this).attr('data-component'))  
            }            
        });

        window.addEventListener('coursevalue', event => 
        {                
            console.log(event.detail);

            if(event.detail.value == false)
            {
                Swal.fire({
                    icon: 'error', 
                    title: 'Oops...',
                    text: event.detail.messsage,
                });
            }
            else
            {
                Livewire.emit('saveCourseAlignEvent');
            }
        });

        // -------------------- send response that page is loaded, ----------------------
        window.addEventListener('loadDropDownData', event => 
        {
            Livewire.emit('LoadDataNow');                          
        });
        // -------------------- load the dropdown data  ----------------------
        window.addEventListener('loadedDataExcepEmployee', event => 
        {  
            Livewire.emit('LoadEmployeeNowCount');      // after data loaded, 
        });
        // -------------------- print data counts ----------------------
        window.addEventListener('loadedEmployeeDataCount', event => 
        {                
            $('#HREmployee').text('Employee ( ' + event.detail.total_employees + ' ) ');
            $('#HRDepartment').text('Department ( ' + event.detail.total_Department + ' ) ');
            $('#HRSubDepartment').text('Sub Department ( ' + event.detail.total_Department + ' ) ');
            $('#HRCourse').text('Course ( ' + event.detail.total_course + ' ) ');
            $('#HRRoles').text('Roles ( ' + event.detail.total_Roles + ' ) ');
            $('#HRInstructors').text('Instructors ( ' + event.detail.total_Instructors + ' ) ');
            $('#HRZone').text('Zones ( ' + event.detail.total_Zones + ' ) ');
            $('#HRCity').text('Cities ( ' + event.detail.total_cities + ' ) ');
            $('#HRBranch').text('Branches ( ' + event.detail.total_Branches + ' ) ');
            $('#HRTimeSlot').text('TimeSlots ( ' + event.detail.total_schedules + ' ) ');

            ApplyAllSelect2();
            // document.querySelectorAll('.WireIgnoreClass').forEach(element => {
            //     element.setAttribute('wire:ignore', true);
            // });

            // console.log('select2 applied ');

        });
        window.addEventListener('ApplySelect2', event => 
        {  
            ApplyAllSelect2();
            
       });
        // -------------------- upon selecting department, show sub departments ----------------------
        window.addEventListener('LoadedSubDepartments', event => 
        {  
                // DestroyAllSelect2();
                $('.loadingSubDepartments').css('display', 'none');
                $('#HRSubDepartment').text('Sub Department ( ' + event.detail.subDepartmentCount + ' ) ');
                SetLoadedData($('.HRSubDepartment'), event.detail.subDepartment);
                // ApplyAllSelect2(true, false, formattedData);
        });

        // -------------------- upon selecting zone, show cities ----------------------
        window.addEventListener('LoadedCities', event => 
        {  
            $('#HRCity').text('City ( ' + event.detail.citiesCount + ' ) ');
            $('.loadingCities').css('display', 'none');                                   
            SetLoadedData($('.HRCities'), event.detail.cities);
        });
        // -------------------- on submitting form, remove temporary uploaded image  ----------------------
        document.addEventListener('livewire:submit', function () 
        {
            document.getElementById('imageInput').value = '';
        });
            
        $('.HRCourse, .HRRoles, .HRInstructors, .employee_new_id, .HRDepartment, .HRSubDepartment, .HRZones, .HRCities, .HRBranches, .HRTimeSlots').on('change', function(e) 
        {         
            console.log('select field ' + $(this).attr('data-id'));
            console.log('select value ' + $(this).select2("val"));
            
            if($(this).attr('data-id') === 'HRZones')
            {
                $('.loadingCities').css('display', 'block');
            }
            
            if($(this).attr('data-id') === 'HRDepartment')
            {
                $('.loadingSubDepartments').css('display', 'block');
            }

            GetDataAttrsAndSetValue($(this));
        });  

        function DestroyAllSelect2()
        {
            $('.HRCourse').select2('destroy');
            $('.HRRoles').select2('destroy');
            $('.HRInstructors').select2('destroy');
            $('.HRDepartment').select2('destroy');
            $('.HRSubDepartment').select2('destroy');
            $('.HRZones').select2('destroy');
            $('.HRCities').select2('destroy');
            $('.HRBranches').select2('destroy');
            $('.HRTimeSlots').select2('destroy');
        }
        function ApplyAllSelect2(SubDepartment = false, City=false, formattedData={})
        {

            const token = getToken();
            const headers = {
                "Authorization": `Bearer ${token}`,
            };
            

            $("#employee_new_id").select2({
                placeholder: "Search Employee",
                minimumInputLength: 2, 
                allowClear: true,
                ajax: {
                    url: GetEmployeeDataRoute, 
                    dataType: "json",
                    delay: 250, 
                    headers: headers,
                    // data: function (params) 
                    // {
                    //     return {
                    //         term: params.term 
                    //     };
                    // },
                    processResults: function (data) 
                    {
                        console.log('get employee entered 2 keys ');

                        return {
                            results: data.map(function (item) 
                            {
                                return {
                                    id: item.id,
                                    text: item.label
                                };
                            })
                        };
                    },
                    cache: true 
                }
            });

            // ---------------------------------HR Department & sub department--------------------------------
            $('.HRDepartment').select2({
                placeholder: 'Please Select Department',
                    allowClear: true
            });

            if(SubDepartment == false)
            {
                $('.HRSubDepartment').select2({
                    placeholder: 'Please Select Parent Department',
                        allowClear: true
                });
            }
            else 
            {
                $('.HRSubDepartment').select2({
                    placeholder: 'Please Select Zone To Get Cities',
                    data: formattedData
                });
            }
            // ---------------------------------HR Course --------------------------------
            $('.HRCourse').select2({
                placeholder: 'Please Select Course',
                    allowClear: true
            });
            // ---------------------------------HR Roles --------------------------------
            $('.HRRoles').select2({
                placeholder: 'Please Select Roles',
                allowClear: true
            });
            // ---------------------------------HR Instructor --------------------------------
            $('.HRInstructors').select2({
                placeholder: 'Please Select Instructor',
                allowClear: true
            });
            // ---------------------------------HR Zone & City --------------------------------
            $('.HRZones').select2({
                placeholder: 'Please Select Zones',
                allowClear: true
            });
                    
            if(City == false)
            {
                $('.HRCities').select2({
                    placeholder: 'Please Select Cities',
                    allowClear: true
                });
            }
            else 
            {
                $('.HRCities').select2({
                    placeholder: 'Please Select Cities',
                    data: formattedData
                });
            }
            
            // ---------------------------------HR Branches --------------------------------
            $('.HRBranches').select2({
                placeholder: 'Please Select Branches',
                allowClear: true
            });
            // ---------------------------------HR Time Slots --------------------------------
            $('.HRTimeSlots').select2({
                placeholder: 'Please Select Time Slot',
                    allowClear: true
            });

            // ---------------------------------ck editor --------------------------------
          
            CKEDITOR.replace('ckeditor');

            CKEDITOR.on('instanceReady', function(evt) {
                const editor = evt.editor;

                editor.on('change', function() 
                {
                    console.log('selected');
                    livewire.emit('SetNotificationBodyEvent',editor.getData());

                    // Find the Livewire component by its ID
                    // const livewireComponent = Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'));
                    // if (livewireComponent) {
                    //     livewireComponent.set('messagebodyCK', editor.getData());
                    // }
                });

                Livewire.on('reinit', () => {
                    editor.setData('');
                });
            });


        }
        function ChangedEmployee()
        {
            console.log('select field Empoyee');
            console.log('select value ' + $('#employee_new_id').val());
            // Livewire.emit('HREmployee', $('#employee_new_id').val());
            GetDataAttrsAndSetValue($('#employee_new_id'), true);
        }
        function GetDataAttrsAndSetValue(Element, Employee=false)
        {
            // console.log('data-id: ' + Element.attr('data-id'));                   // HRRoles
            // console.log('data-table: ' + Element.attr('data-table'));             // ecom_user_roles
            // console.log('data-table-field: ' + Element.attr('data-table-field')); // role_id , this is the field in current component model

            var value='';

            if(Employee)
            {
                value = Element.val();
            }
            else
            {
                value = Element.select2("val");
                // console.log(value);
            }
            Livewire.emit('UpdateValue', Element.attr('data-table'), Element.attr('data-table-field'), value)
        }
        function SetLoadedData(Element, LoadedData)
        {
            var formattedData = Object.entries(LoadedData).map(([text, id]) => ({
                                        id: id,
                                        text: text
                                    }));

            Element.empty()

            Element.select2({
                placeholder: 'Please Select Sub Department',
                data: formattedData
            });
            Element.trigger('change');
        }
        function ValidateElements(Component)
        {
            if(Component == 'SendNotification')
            {
                
                var TitleElement= $('.TitleElement').val();
                // var BodyElement= $('.BodyElement').val();
                var BodyElement = CKEDITOR.instances['ckeditor'].getData();

                // console.log(typeof TitleElement);             //string
                // console.log('value: ' +  TitleElement);  //value: 
                // console.log(typeof BodyElement);   // undefined
                // console.log('value: ' +  BodyElement);  //value: undefined


                if (TitleElement !== '' && BodyElement !== '') {
                    return true;
                } else {
                    console.log('TitleElement: ' + TitleElement);
                    console.log('BodyElement: ' + BodyElement);
                    return false;
                }
            }
            else if(Component == 'SendCourseAlignment')
            {
                Livewire.emit('CheckCourseSelectedEvent');
            }
        }

        // <!-- Service Worker Registration -->
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/firebase-messaging-sw.js')
                    .then(function(registration) {
                        console.log('Service Worker registered:', registration);
                    })
                    .catch(function(error) {
                        console.error('Service Worker registration failed:', error);
                    });
            });
        }


