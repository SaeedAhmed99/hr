<label for="{{ $id }}">Select Year</label>
<select name="{{ $name }}" id="{{ $id }}" class="form-control">
    @php
        $year = 2013;
        for ($i = 0; $i <= 13; $i++) {
            if(date('M') == "Jan"){
                $year--;
            }
            if($selected == $year){
                echo "<option selected>$year</option>" ;
            }else{
                echo "<option>$year</option>" ;
            }
            $year++;
        }
    @endphp
</select>