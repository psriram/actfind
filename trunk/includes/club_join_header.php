<div class="container">
    <div class="row smpl-step" style="border-bottom: 0; min-width: 500px;">
        <div class="col-xs-3 smpl-step-step complete">
            <div class="text-center smpl-step-num">Step 1</div>
            <div class="progress">
                <div class="progress-bar"></div>
            </div>
            <a class="smpl-step-icon"><i class="fa fa-user" style="font-size: 60px; padding-left: 12px; padding-top: 3px; color: black;"></i></a>
            <div class="smpl-step-info text-center">Add Club</div>
        </div>

        <div class="col-xs-3 smpl-step-step complete">
            <div class="text-center smpl-step-num">Step 2</div>
            <div class="progress">
                <div class="progress-bar"></div>
            </div>
            <a class="smpl-step-icon"><i class="fa fa-calendar" style="font-size: 60px; padding-left: 18px; padding-top: 5px; color: black;"></i></a>
            <div class="smpl-step-info text-center">Add Schedule</div>
        </div>
        <div class="col-xs-3 smpl-step-step active">
            <div class="text-center smpl-step-num">Step 3</div>
            <div class="progress">
                <div class="progress-bar"></div>
            </div>
            <a class="smpl-step-icon"><i class="fa fa-file" style="font-size: 60px; padding-left: 7px; padding-top: 7px; color: black;"></i></a>
            <div class="smpl-step-info text-center">Preview</div>
        </div>

    </div>
</div>

<style>
    .smpl-step {
        margin-top: 40px;
    }
    .smpl-step {
        border-bottom: solid 1px #e0e0e0;
        padding: 0 0 10px 0;
    }

    .smpl-step > .smpl-step-step {
        padding: 0;
        position: relative;
    }

    .smpl-step > .smpl-step-step .smpl-step-num {
        font-size: 17px;
        margin-top: -20px;
        margin-left: 47px;
    }

    .smpl-step > .smpl-step-step .smpl-step-info {
        font-size: 14px;
        padding-top: 27px;
    }

    .smpl-step > .smpl-step-step > .smpl-step-icon {
        position: absolute;
        width: 70px;
        height: 70px;
        display: block;
        background: #5CB85C;
        top: 45px;
        left: 50%;
        margin-top: -35px;
        margin-left: -15px;
        border-radius: 50%;
    }

    .smpl-step > .smpl-step-step > .progress {
        position: relative;
        border-radius: 0px;
        height: 8px;
        box-shadow: none;
        margin-top: 37px;
    }

   .smpl-step > .smpl-step-step > .progress > .progress-bar {
       width: 0px;
       box-shadow: none;
       background: #428BCA;
   }

    .smpl-step > .smpl-step-step.complete > .progress > .progress-bar {
        width: 100%;
    }

    .smpl-step > .smpl-step-step.active > .progress > .progress-bar {
        width: 50%;
    }

    .smpl-step > .smpl-step-step:first-child.active > .progress > .progress-bar {
        width: 0%;
    }

    .smpl-step > .smpl-step-step:last-child.active > .progress > .progress-bar {
        width: 100%;
    }

    .smpl-step > .smpl-step-step.disabled > .smpl-step-icon {
        background-color: #f5f5f5;
    }

    .smpl-step > .smpl-step-step.disabled > .smpl-step-icon:after {
        opacity: 0;
    }

    .smpl-step > .smpl-step-step:first-child > .progress {
        left: 50%;
        width: 50%;
    }

    .smpl-step > .smpl-step-step:last-child > .progress {
        width: 50%;
    }

    .smpl-step > .smpl-step-step.disabled a.smpl-step-icon {
        pointer-events: none;
    }
</style>
 <?php if($_REQUEST["error"]==1){ ?>
      <div id="divError" class="row text-center">
        Errors saving club.
      </div>
   <?php } ?>