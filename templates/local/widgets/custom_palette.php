<?php if(config_db_item('app_type') == 'demo' || $this->session->userdata('type') == 'ADMIN'): ?>
<div class="custom-palette  palette-closed">
    <div class="custom-palette-box">
        <div class="custom-palette-box-pr">
            <div class="row-fluid">
                <div class='palette-prepared' id='palette-colors-prepared'>
                    <label class="label-title"><?php echo lang_check('Color Variant');?></label>
                    <ul class="palette-prepared-list palette-colors clearfix">
                        <li class="palette-color-red" data-color-id='red' 
                            data-backgroundtopbar='#fc2d2f' 
                            data-primary-color='#fc2d2f' 
                            data-secondary-color='#a61c1d' 
                            data-btnprimary='#da3743' 
                            data-btnprimaryhover='#c5434d'
                            data-titlescolor='#6b2525'
                            data-subtitlescolor='#730707'
                            data-titlesprimary='#d12123'
                            data-titlesecondary='#6e1717'
                            data-contentcolor='#171616'
                            ><a href="#" title='red'></a></li>
                        <li class="palette-color-pink" 
                            data-color-id='pink' 
                            data-backgroundtopbar='#bf224e' 
                            data-primary-color='#bf224e' 
                            data-secondary-color='#940a31' 
                            data-btnprimary='#F62459' 
                            data-btnprimaryhover='#DB0A5B'
                            data-titlescolor='#5a626b'
                            data-subtitlescolor='#6c7a89'
                            data-titlesprimary='#26A65B'
                            data-titlesecondary='#674172'
                            data-contentcolor='#372b3b'
                            ><a href="#" title='pink'></a></li>
                        <li class="palette-color-blue" data-color-id='blue' 
                            data-backgroundtopbar='#01A8CC' 
                            data-primary-color='#01A8CC' 
                            data-secondary-color='#004790' 
                            data-btnprimary='#01A8CC' 
                            data-btnprimaryhover='#1d6eb3'
                            data-titlescolor='#252525'
                            data-subtitlescolor='#7b7b7b'
                            data-titlesprimary='#00B16A'
                            data-titlesecondary='#2a3138'
                            data-contentcolor='#353535'
                            ><a href="#" title='blue'></a></li>
                        <li class="palette-color-green" data-color-id='green' 
                            data-backgroundtopbar='#1fc569' 
                            data-primary-color='#1fc569' 
                            data-secondary-color='#2f913c' 
                            data-btnprimary='#1fc569' 
                            data-btnprimaryhover='#317a3b'
                            data-titlescolor='#1E824C'
                            data-subtitlescolor='#1e824c'
                            data-titlesprimary='#4285f4'
                            data-titlesecondary='#000000'
                            data-contentcolor='#232323'
                            ><a href="#" title='green'></a></li>
                        <li class="palette-color-cyan" data-color-id='cyan' 
                            data-backgroundtopbar='#0aa699' 
                            data-primary-color='#0aa699' 
                            data-secondary-color='#197069' 
                            data-btnprimary='#9d098c' 
                            data-btnprimaryhover='#8a277e'
                            data-titlescolor='DB0A5B'
                            data-subtitlescolor='#D2527F'
                            data-titlesprimary='#db0a5b'
                            data-titlesecondary='#000000'
                            data-contentcolor='#000000'
                            ><a href="#" title='cyan'></a></li>
                        <li class="palette-color-purple" data-color-id='purple' 
                            data-backgroundtopbar='#7061a4' 
                            data-primary-color='#7061a4' 
                            data-secondary-color='#5a2f5c' 
                            data-btnprimary='#913d88' 
                            data-btnprimaryhover='#995091'
                            data-titlescolor='#252525'
                            data-subtitlescolor='#7b7b7b'
                            data-titlesprimary='#4285f4'
                            data-titlesecondary='#252525'
                            data-contentcolor='#353535'
                            ><a href="#" title='purple'></a></li>
                        <li class="palette-color-orange" data-color-id='orange' 
                            data-backgroundtopbar='#d9b62e' 
                            data-primary-color='#e68c2c' 
                            data-secondary-color='#e68c2c' 
                            data-btnprimary='#e68c2c' 
                            data-btnprimaryhover='#ba7225'
                            data-titlescolor='#252525'
                            data-subtitlescolor='#7b7b7b'
                            data-titlesprimary='#4285f4'
                            data-titlesecondary='#252525'
                            data-contentcolor='#353535'
                            ><a href="#" title='orange'></a></li>
                        <li class="palette-color-brown" data-color-id='brown' 
                            data-backgroundtopbar='#846447' 
                            data-primary-color='#846447' 
                            data-secondary-color='#a1764f' 
                            data-btnprimary='#CA6924' 
                            data-btnprimaryhover='#E08A1E'
                            data-titlescolor='#846447'
                            data-subtitlescolor='#7c5c3f'
                            data-titlesprimary='#446CB3'
                            data-titlesecondary='#9d4e06'
                            data-contentcolor='#9c4d06'
                            ><a href="#" title='brown'></a></li>
                    </ul>
                </div>
                <div class="custom-palette-color hidden" >
                    <label class="label-title"><?php echo lang_check('Top Bar version');?></label>
                    <div class="input-group" id="topbar-version">
                        <select name="font-family" class="selectpicker">
                            <option value=""><?php echo lang_check('Choose style...');?></option>
                            <option value="white"><?php echo lang_check('White');?></option>
                            <option value="color"><?php echo lang_check('Color');?></option>
                        </select>
                    </div>
                </div>

                <div class="custom-palette-color hidden" >
                    <label class="label-title"><?php echo lang_check('Background top-bar');?></label>
                    <div class="input-group" id="color-top-bar-bg">
                        <input type="text" value="" class="form-control" />
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
                
                <div class="custom-palette-color" >
                    <label class="label-title"><?php echo lang_check('Primary color');?></label>
                    <div class="input-group" id="color-primary">
                        <input type="text" value="" class="form-control" />
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
                <div class="custom-palette-color">
                    <label class="label-title"><?php echo lang_check('Secondary color');?></label>
                    <div class="input-group" id="color-secondary">
                        <input type="text" value="" class="form-control" />
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
                <div>
                    <a data-toggle="collapse" data-target="#additional_palette" class="additional_palette"><span class="label-title"><?php echo lang_check('More Options');?> <span class="caret"></span></span></a>
                    <div id="additional_palette" class="collapse">

                        <div class="custom-palette-color">
                            <label class="label-title"><?php echo lang_check('Titles color');?></label>
                            <div class="input-group" id="color-titles">
                                <input type="text" value="" class="form-control" />
                                <span class="input-group-addon"><i></i></span>
                            </div>
                        </div>

                        <div class="custom-palette-color">
                            <label class="label-title"><?php echo lang_check('Sub-Titles color');?></label>
                            <div class="input-group" id="color-subtitles">
                                <input type="text" value="" class="form-control" />
                                <span class="input-group-addon"><i></i></span>
                            </div>
                        </div>

                        <div class="custom-palette-color">
                            <label class="label-title"><?php echo lang_check('Titles primary');?></label>
                            <div class="input-group" id="color-titles-primary">
                                <input type="text" value="" class="form-control" />
                                <span class="input-group-addon"><i></i></span>
                            </div>
                        </div>

                        <div class="custom-palette-color">
                            <label class="label-title"><?php echo lang_check('Titles secondary');?></label>
                            <div class="input-group" id="color-titles-secondary">
                                <input type="text" value="" class="form-control" />
                                <span class="input-group-addon"><i></i></span>
                            </div>
                        </div>

                        <div class="custom-palette-color">
                            <label class="label-title"><?php echo lang_check('Color content');?></label>
                            <div class="input-group" id="color-content">
                                <input type="text" value="" class="form-control" />
                                <span class="input-group-addon"><i></i></span>
                            </div>
                        </div>

                        <div class="custom-palette-color">
                            <label class="label-title"><?php echo lang_check('Primary Btn');?></label>
                            <div class="input-group" id="color-primary-btn">
                                <input type="text" value="" class="form-control" />
                                <span class="input-group-addon"><i></i></span>
                            </div>
                        </div>
                        <div class="custom-palette-color">
                            <label class="label-title"><?php echo lang_check('Primary Btn hover');?></label>
                            <div class="input-group" id="color-primary-btnhover">
                                <input type="text" value="" class="form-control" />
                                <span class="input-group-addon"><i></i></span>
                            </div>
                        </div>

                        <div class="custom-palette-color">
                            <label class="label-title"><?php echo lang_check('Main Font');?></label>
                            <div class="input-group" id="font-family">
                                <select name="font-family" class="selectpicker">
                                    <option value="Arial">Arial</option>
                                    <option value="Antiqua">Antiqua</option>
                                    <option value="Avqest">Avqest</option>
                                    <option value="Blackletter">Blackletter</option>
                                    <option value="Calibri">Calibri</option>
                                    <option value="Comic Sans M">Comic Sans M</option>
                                    <option value="Comic Sans">Comic Sans</option>
                                    <option value="Courier New">Courier New</option>
                                    <option value="cursive">Cursive</option>
                                    <option value="fantasy">Fantasy</option>
                                    <option value="Geneva">Geneva</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Helvetica">Helvetica</option>
                                    <option value="Impact, Charcoal">Impact, Charcoal</option>
                                    <option value="Lucida Sans Unicode">Lucida Sans Unicode</option>
                                    <option value="Lucida Console">Lucida Console</option>
                                    <option value="monospace">Monospace</option>
                                    <option value="Nunito" selected='selected'>Nunito</option>
                                    <option value="serif">Serif</option>
                                    <option value="sans-serif">Sans-serif</option>
                                    <option value="Times New Roman">Times New Roman</option>
                                    <option value="Times">Times</option>
                                    <option value="Tahoma">Tahoma</option>
                                    <option value="Verdana">Verdana</option>
                                </select>
                            </div>
                        </div>

                        <div class="custom-palette-color">
                            <label class="label-title"><?php echo lang_check('Fonts size');?></label>
                            <div class="input-group" id="font-size">
                                <select name="font-size" class="selectpicker">
                                    <option value="-3">-3</option>
                                    <option value="-2">-2</option>
                                    <option value="-1">-1</option>
                                    <option value="0" selected="selected">0</option>
                                    <option value="+1">+1</option>
                                    <option value="+2">+2</option>
                                    <option value="+3">+3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="custom-palette-color">
                    <div class="input-group">
                        <label class="c-input c-radio">
                            <input name="type-site" type="radio" value="boxed">
                            <span class="c-indicator"></span>
                            boxed
                        </label>

                        <label class="c-input c-radio">
                            <input name="type-site" type="radio" value="" checked="checked">
                            <span class="c-indicator"></span>
                            wide
                        </label>
                    </div>
                </div>
                <div class="custom-palette-color" id='pallete-background-boxed'>
                    <label class="label-title"><?php echo lang_check('Background color');?></label>
                    <div class="input-group" id="color-background">
                        <input type="text" value="" class="form-control" />
                        <span class="input-group-addon"><i></i></span>
                    </div>
                    <div class='palette-prepared' id='palette-backgroundimage-prepared'>
                        <ul class="palette-prepared-list palette-prepared-list-images clearfix">
                            <li data-backgroundimage-style='fixed' data-backgroundimage='assets/img/patterns/bg-white-lily-l.jpg'><a href="#"><img src="assets/img/patterns/bg-white-lily-l-min.jpg" alt="white" /></a></li>
                            <li data-backgroundimage-style='fixed' data-backgroundimage='assets/img/patterns/bg-grass-m.jpg'><a href="#"><img src="assets/img/patterns/bg-grass-m-min.jpg" alt="grass" /></a></li>
                            <li data-backgroundimage-style='fixed' data-backgroundimage='assets/img/patterns/bg-villa-m.jpg'><a href="#"><img src="assets/img/patterns/bg-villa-m-min.jpg" alt="villa" /></a></li>
                            <li data-backgroundimage-style='fixed' data-backgroundimage='assets/img/patterns/wood-background-m.jpg'><a href="#"><img src="assets/img/patterns/wood-background-m-min.jpg" alt="background" /></a></li>
                            <li data-backgroundimage-style='fixed' data-backgroundimage='assets/img/patterns/bg-a-farm-l.jpg'><a href="#"><img src="assets/img/patterns/bg-a-farm-l-min.jpg" alt="farm" /></a></li>
                            <li data-backgroundimage-style='fixed' data-backgroundimage='assets/img/patterns/bg-lavender.jpg'><a href="#"><img src="assets/img/patterns/bg-lavender-min.jpg" alt="lavender" /></a></li>
                            <li data-backgroundimage-style='fixed' data-backgroundimage='assets/img/patterns/full-bg-ocean.jpg'><a href="#"><img src="assets/img/patterns/full-bg-ocean-min.jpg" alt="ocean" /></a></li>
                            <li data-backgroundimage-style='fixed' data-backgroundimage='assets/img/patterns/full-bg-road.jpg'><a href="#"><img src="assets/img/patterns/full-bg-road-min.jpg" alt="road" /></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <?php if($this->session->userdata('type') == 'ADMIN' && config_db_item('app_type') != 'demo'): ?>
            <div class="row-fluid text-center">
                <a href="" class="btn btn-primary full-width btn-wide" id="design-save"><span><?php echo lang_check('Save');?></span></a>
            </div>
            <script>
                $(document).ready(function() {
                    //'use strict';

                    $('#design-save').click(function(e) {
                        e.preventDefault();
                        var color= '';

                        color = {
                            'font_size':$('#font-size select').val(),
                            'font_family':$('#font-family select').val(),
                            'color_primary_btnhover':$('#color-primary-btnhover input').val(),
                            'color_primary_btn':$('#color-primary-btn input').val(),
                            'color_content':$('#color-content input').val(),
                            'color_titles_secondary':$('#color-titles-secondary input').val(),
                            'color_titles_primary':$('#color-titles-primary input').val(),
                            'color_subtitles':$('#color-subtitles input').val(),
                            'color_titles':$('#color-titles input').val(),
                            'color_top_bar_bg':$('#color-top-bar-bg input').val(),
                            'topbar_version':$('#topbar-version select').val(),
                            'primary_color':$('#color-primary input').val(),
                            'secondary_color':$('#color-secondary input').val(),
                            'background_color':$('#color-background input').val(),
                            'background_image':$('#palette-backgroundimage-prepared .active').closest('li').attr('data-backgroundimage'),
                            'background_image_style':$('#palette-backgroundimage-prepared .active').closest('li').attr('data-backgroundimage-style')
                        }

                        color = JSON.stringify(color)

                        var data = { design_parameters: $('body').attr('class').replace('admin_access',''), css_variant: '', color: color };

                        var load_indicator = $(this).find('.load-indicator');
                        load_indicator.css('display', 'inline-block');
                        $.post("{api_private_url}/design_save/{lang_code}", data, 
                               function(data){

                            ShowStatus.show(data.message);

                            load_indicator.css('display', 'none');
                        });

                        return false;
                    });
                });
            </script>
            <?php endif; ?>
            <div class="row-fluid text-center">
                <a href="" class="btn btn-basic btn-wide" id="pallete-reset"><span><?php echo lang_check('Reset');?></span></a>
            </div>
            <a class="btn custom-palette-btn">
                <img src="assets/img/icon/settings.png" alt="settings"/>
            </a>
        </div>
    </div>
</div><!-- /.custom-palette -->   <!-- /.footer -->
<?php endif;?>