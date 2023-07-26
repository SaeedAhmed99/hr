<label for="{{ $id }}">Select Month</label>
<select name="{{ $name }}" id="{{ $id }}" class="form-control">
    @php
        for ($i = 1; $i <= 12; $i++) {
            $month = \Carbon\Carbon::createFromDate(date('Y'), $i, 1)->format('F');
            if($selected == $i){
                echo "<option value='$i' selected>$month</option>";
            }else{
                echo "<option value='$i'>$month</option>";
            }
        }
    @endphp
</select>