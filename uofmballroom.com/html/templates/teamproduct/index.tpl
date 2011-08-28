{include file='header.tpl'  toplink='true'}

<div id="leftContainer">
	<form>
    	Please complete your following information<br/>
    	<fieldset id="basicInfo">
        <legend>(1) Your basic Information</legend>
    	<label>Name:</label><input type="text" /><br/>
        <label>Phone:</label><input type="text" /><br/>
        <label>Email:</label><input type="text" /><br/>
        </fieldset>
        
       	<fieldset >
        <legend>(2 optional) Michigan Ballroom Track Jacket (Navy Blue - Men's Sizes) - $35.00</legend>
    	<label>Name to be embroider on front of Jacket:</label><input type="text" /><br/>
        <label>S:</label><input type="text" placeholder="Enter quantity" class="trackJacketFieldSetsSizes"/>
        <label>M:</label><input type="text" placeholder="Enter quantity" class="trackJacketFieldSetsSizes"/>
        <label>L:</label><input type="text" placeholder="Enter quantity" class="trackJacketFieldSetsSizes"/>
        <label>XL:</label><input type="text" placeholder="Enter quantity" class="trackJacketFieldSetsSizes" />
        </fieldset>
        
        <fieldset >
        <legend>(3 optional) "Real Men Need More Ballroom" T-Shirt - $10 each</legend>
        ***Men's sizes are available in S, M, L, XL<br/>
        ***Women's sizes are available in S, M, L<br/>
        Shirt 1: <input type="radio" name="shirt3[0][gender]" />Male
        <input type="radio" name="shirt3[0][gender]" />Female
        <select name="shirt3[0][size]">
        	<option>Size: </option>
            <option>S: </option>
            <option>M: </option>
            <option>L: </option>
            <option>XL: </option>
        </select>
        <select name="shirt3[0][quantity]">
        	<option>Quantity: </option>
            <option>1: </option>
            <option>2: </option>
            <option>3: </option>
            <option>4: </option>
            <option>5: </option>
        </select>
        <select name="shirt3[0][color]">
        	<option>Color: </option>
            <option>Black: </option>
            <option>Blue: </option>
            <option>Cranberry: </option>
            <option>Evergreen: </option>
            <option>Maize/Navy: </option>
            <option>Pink: </option>
        </select><br/>
        Shirt 2: <input type="radio" name="shirt3[1][gender]" />Male
        <input type="radio" name="shirt3[1][gender]" />Female
        <select name="shirt3[1][size]">
        	<option>Size: </option>
            <option>S: </option>
            <option>M: </option>
            <option>L: </option>
            <option>XL: </option>
        </select>
        <select name="shirt3[1][quantity]">
        	<option>Quantity: </option>
            <option>1: </option>
            <option>2: </option>
            <option>3: </option>
            <option>4: </option>
            <option>5: </option>
        </select>
        <select name="shirt3[1][color]">
        	<option>Color: </option>
            <option>Black: </option>
            <option>Blue: </option>
            <option>Cranberry: </option>
            <option>Evergreen: </option>
            <option>Maize/Navy: </option>
            <option>Pink: </option>
        </select><br/>
        Shirt 3: <input type="radio" name="shirt3[2][gender]" />Male
        <input type="radio" name="shirt3[2][gender]" />Female
        <select name="shirt3[2][size]">
        	<option>Size: </option>
            <option>S: </option>
            <option>M: </option>
            <option>L: </option>
            <option>XL: </option>
        </select>
        <select name="shirt3[2][quantity]">
        	<option>Quantity: </option>
            <option>1: </option>
            <option>2: </option>
            <option>3: </option>
            <option>4: </option>
            <option>5: </option>
        </select>
        <select name="shirt3[2][color]">
        	<option>Color: </option>
            <option>Black: </option>
            <option>Blue: </option>
            <option>Cranberry: </option>
            <option>Evergreen: </option>
            <option>Maize/Navy: </option>
            <option>Pink: </option>
        </select>
        </fieldset>
    
    
    	<fieldset>
        	<legend>(4 optional) Michigan Ballroom T-Shirt - $10 each</legend>
            ***Men's sizes are available in S, M, L, XL<br/>
        	***Women's sizes are available in S, M, L<br/>
             <label>S:</label><input type="text" placeholder="Enter quantity" class="trackJacketFieldSetsSizes"/>
        <label>M:</label><input type="text" placeholder="Enter quantity" class="trackJacketFieldSetsSizes"/>
        <label>L:</label><input type="text" placeholder="Enter quantity" class="trackJacketFieldSetsSizes"/>
        <label>XL:</label><input type="text" placeholder="Enter quantity" class="trackJacketFieldSetsSizes" />
        </fieldset>
        
        <fieldset>
        	<legend>(5 optional) Michigan Ballroom Shoe Bag - $10 each</legend>
           		<label>Name to be embroider on front of Shoe Bag:</label><input type="text" />
        		<select name="">
                    <option>Quantity: </option>
                    <option>1: </option>
                    <option>2: </option>
                    <option>3: </option>
                    <option>4: </option>
                    <option>5: </option>
                </select>
        </fieldset>
        
         <fieldset>
        	<legend>(6 optional) Michigan Ballroom Garment Bag - $15 each</legend>
           		<label>Name to be embroider on front of Garment Bag:</label><input type="text" />
        		<select name="">
                    <option>Quantity: </option>
                    <option>1: </option>
                    <option>2: </option>
                    <option>3: </option>
                    <option>4: </option>
                    <option>5: </option>
                </select>
        </fieldset>
        
        
        <input type="button" value="Submit apparel form" style="padding: 5px;"/>
   	</form>
</div>


{literal}

<style>
.trackJacketFieldSetsSizes{
	width: 100px;	
}

</style>
{/literal}
	
{include file='footer.tpl'  products=$cartObject}