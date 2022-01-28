function generateElements(){
    let awardees_no = parseInt(document.getElementById("awardees_no").value)
    let main_contain = document.getElementById("awards_form")
    let comp_count = parseInt(document.getElementById("lead_count").value)
    if (isNaN(awardees_no) == true) {
      Swal.fire(
        'Invalid input!',
        'Input must be a number',
        'error'
      )
    }
    else if(awardees_no < 1){
      Swal.fire(
        'Invalid input!',
        'Input must be greater than 1',
        'error'
      )
    }
    else if(awardees_no > 5){
      Swal.fire(
        'Invalid input!',
        'Input must not be greater than 5',
        'error'
      )
    }
    else if(awardees_no > comp_count){
      Swal.fire(
        'Invalid input!',
        'Input greater than total participants in leaderboard',
        'error'
      )
    }
    else{
        main_contain.innerHTML = ""
        document.getElementById("gen_inst").style = "display: block";
        document.getElementById("btn_req").style = "display: block";
        for (let i = 0; i < awardees_no; i++) {
        
        //create div to hold the input fields
        let input_contain = document.createElement('div')
        input_contain.classList.add('mb-3')
        main_contain.appendChild(input_contain)

        //Create label for input field
        let titleLabel = document.createElement('label')
        let count = i + 1
        titleLabel.textContent = 'Position '+count
        titleLabel.classList.add('mb-2')

        //Create prize amount input field
        let titleEmailInput = document.createElement('input')
        titleEmailInput.type = "email"
        titleEmailInput.name = "part_email"+i
        titleEmailInput.classList.add('form-control')
        titleEmailInput.classList.add('mb-1')
        titleEmailInput.setAttribute('id', "part_email"+i)
        titleEmailInput.placeholder = 'Email address e.g username@emailserver.com'

        //Create prize amount input field
        let titlePrizeInput = document.createElement('input')
        titlePrizeInput.type = "number"
        titlePrizeInput.name = "position"+i
        titlePrizeInput.classList.add('form-control')
        titlePrizeInput.setAttribute('id', "position"+i)
        titlePrizeInput.placeholder = 'Prize amount e.g 5000'

        input_contain.appendChild(titleLabel)
        input_contain.appendChild(titleEmailInput)
        input_contain.appendChild(titlePrizeInput)
      }
    }
  }

  var gen_fields = document.getElementById("gen_fields")
  gen_fields.addEventListener('click', (e)=>{
    e.preventDefault()
    generateElements()
  })

  //JQuery Logic
    $(document).ready(function() {
        $('#example').DataTable();
        $('#example1').DataTable();
        $('#example2').DataTable();
        $('#example3').DataTable();

        //Snippet to disqualify participant
        $("#example").on('click', '.disq', function(e){
          e.preventDefault()
          var parent = $(this).parent('td').parent('tr')
          var pid = $(this).attr('data-id');
          Swal.fire({
            title: 'Do you really want to disqualify this participant?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, continue!'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                type: "post",
                url: "managepart.php",
                data: {part_ID: pid, type: "disq"}
              }).done(function(msg) {
                  if (msg == "success") {
                    parent.fadeOut('slow')
                    Swal.fire({
                      title: 'Success!',
                      text: "Diqualified successfully!",
                      icon: 'success',
                      showCancelButton: false
                      }).then((result) => {
                      if (result.isConfirmed) {
                          location.reload()
                      }
                    })
                  }
              }).fail(function(msg){
                console.log(msg)
              })
            }
          })     
        })

        //Snippets to verify pending participant
        $("#example1").on('click', '.verify', function(e){
          e.preventDefault()
          var parent = $(this).parent('td').parent('tr')
          var pid = $(this).attr('data-id');
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, continue!'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                type: "post",
                url: "managepart.php",
                data: {part_ID: pid, type: "verify"}
              }).done(function(msg) {
                  if (msg == "success") {
                    parent.fadeOut('slow')
                    Swal.fire({
                      title: 'Success!',
                      text: "Verified successfully!",
                      icon: 'success',
                      showCancelButton: false
                      }).then((result) => {
                      if (result.isConfirmed) {
                          location.reload()
                      }
                    })
                  }
              }).fail(function(msg){
                console.log(msg)
              })
            }
          })     
        })

        //Snippet to verify all pending participants at once
        $("#verifyall").click(function(e){
          e.preventDefault()
          var compid = $(this).attr('data-compid');
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, continue!'
          }).then((result) => {
            if (result.isConfirmed) {
              SlickLoader.enable();
              SlickLoader.setText("Please wait...");
              $.ajax({
                type: "post",
                url: "managepart.php",
                data: {comp_ID: compid, verify_all: 'v_all'}
              }).done(function(msg) {
                  SlickLoader.disable();
                  if (msg == "success") {
                    Swal.fire({
                      title: 'Success!',
                      text: "Verified successfully!",
                      icon: 'success',
                      showCancelButton: false
                      }).then((result) => {
                      if (result.isConfirmed) {
                          location.reload()
                      }
                    })
                  }
              }).fail(function(msg){
                console.log(msg)
              })
            }
          })     
        })

        //Snippet to request payout
        $("#btn_req").click(function(e){
          e.preventDefault()
          var awardees_no = $("#awardees_no").val();
          var amounts = [];
          var emails = [];
          var deposit = parseInt($("#deposit").attr('data-amount'))
          var sum = 0;
          var compid = $(this).attr('data-compid');
          // var tag = $(this).attr('data-tag');
          for (let i = 0; i < awardees_no; i++) {
            let amount = parseInt($("#position"+i).val()) || 0;
            amounts.push(amount); 
          }
          for (let i = 0; i < awardees_no; i++) {
            let email = $("#part_email"+i).val();
            emails.push(email); 
          }
          for (let i = 0; i < amounts.length; i++) {
            sum += amounts[i];       
          }
          if (sum > deposit) {
              Swal.fire(
                'Invalid total',
                'total must not be greater than deposit amount!',
                'error'
              )
          }
          else if(amounts.includes(0)){
              Swal.fire(
                'Error',
                'All fields are required',
                'error'
              )
          }
          else{
            SlickLoader.enable();
            SlickLoader.setText("Please wait...");
            $.ajax({
              type: "post",
              url: "managepart.php",
              data: {awardees: awardees_no, amounts: amounts.toString(), compID: compid, emails: emails.toString()}
            }).done(function(msg){
                SlickLoader.disable();
                if (msg == "success") {
                  Swal.fire({
                  title: 'Success!',
                  text: "Payout request sent successfully! You will receive a confirmation email from us within the next 24 hours.",
                  icon: 'success',
                  showCancelButton: false
                }).then((result) => {
                    if (result.isConfirmed) {
                      location.replace("mycompetitions.php")
                    }
                  }) 
                }
                else{
                  Swal.fire(
                    'Error',
                    msg,
                    'error'
                  )
                }
            }).fail(function(msg){
              console.log(msg)
            })
          }
        })

    });


    tinymce.init({
      selector: 'textarea#desc',
      height: 170,
      plugins: [
        'emoticons paste'
        ],
        toolbar: 'insertfile undo redo | bold italic | fullpage | emoticons',
        menubar: ''
   });
   tinymce.init({
      selector: 'textarea#req',
      height: 170,
      plugins: [
        'emoticons paste lists'
        ],
        toolbar: 'insertfile undo redo | bold italic | fullpage | bullist | emoticons',
        menubar: ''
   });
   tinymce.init({
      selector: 'textarea#rules',
      height: 170,
      plugins: [
        'emoticons paste lists'
        ],
        toolbar: 'insertfile undo redo | bold italic | fullpage | bullist | emoticons',
        menubar: ''
   });