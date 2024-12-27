<?php 
echo '<tr id="'.$ID.'" ><td><select class="form-control BookingType" id="BookingType'.$ID.'" data-BID="'.$ID.'" name="BookingType[]" required="required"  ></select><div ></div></td> 
<td><select class="form-control Material " id="DescriptionofMaterial'.$ID.'" name="DescriptionofMaterial[]" required="required" data-live-search="true"  ></select><div ></div></td> 
<td><select class="form-control LoadType" id="LoadType'.$ID.'" name="LoadType[]" required="required"  > <option value="1">Loads</option><option value="2">TurnAround</option></select> </td> 
<td><select class="form-control LorryType" id="LorryType'.$ID.'" name="LorryType[]"  data-live-search="true" ><option value="" >Select</option><option value="1" >Tipper</option><option value="2" >Grab</option><option value="3" >Bin</option></select></td> 
<td><select class="form-control Loads" id="Loads'.$ID.'" name="Loads[]" required="required"   data-live-search="true" >  
</select></td> 
<td><div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="text" class="form-control required BookingDateTime" data-BID="'.$ID.'" id="BookingDateTime'.$ID.'" autocomplete="off" value="" name="BookingDateTime[]" maxlength="65"></div><div ></div></td> 
<td><input type="text" class="form-control Price" id="Price1" data-BID="'.$ID.'"    name="Price[]" value="" ><span id="pdate1" style="font-size:12px"></span></td> 
<td><span id="Total1" style="font-size:12px"></span><input type="hidden" id="TotalHidden1"  name="TotalHidden[]"  > </td> </tr>';
?>