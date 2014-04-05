@extends('site.layouts.default')

@section('scripts')
    <script type="text/javascript">

        function showAlert() {
            $("#myAlert").addClass("in"); 
        }

        window.setTimeout(function () {
            showAlert();
        }, 2000);

        $(document).ready(function() {
            // TOOLTIP
            $('.tooltip-test, .tooltip-test2 a, .tooltip-test2 button').tooltip();// initialize with default options
            // POPOVER
            $('.popover-test, .popover-test2 a, .popover-test2 button').popover();// initialize with default options
            // SAMPLE LOADING BUTTON
            $('#loading-example-btn').click(function () {
                var btn = $(this)
                btn.button('loading')
                setTimeout(function() {
                    btn.button('reset')
                }, 2000);
            // $.ajax().always(function () {
            //   btn.button('reset')
            // });
            });

            // AFFIX: set up scrollSpy on scrollable element
            // append data-spy=scroll to body, since scrolling is conducted/spied on the main window
            // append the data-target as the nav element we are targeting
            $('body').attr('data-spy', 'scroll').attr('data-target', '.test-sidebar');
        });

    </script>
@stop

@section('styles')

    .show-grid {
        margin-bottom: 15px;
    }

    .show-grid [class^="col-"], .test-show-grid [class^="test-content-"] {
        background-color: rgba(86, 61, 124, 0.15);
        border: 1px solid rgba(86, 61, 124, 0.2);
        padding-bottom: 10px;
        padding-top: 10px;
    }

    h5 {
        margin-left: -15px;
        font-weight: 400;
        margin-top: 25px;
        background-color: #dbdcff;
        padding: 9px;
        padding-bottom: 9px;
        text-transform:uppercase;
    }

    section {
        padding-top: 40px;
        margin-top: -40px;
    }

@stop

{{-- Content --}}
@section('content')

<div id='colorbox'>pink and red</div>

<div class="row">
    <div class="col-md-10">

        {{-- ******************************** GRID ********************************* --}}
        <br>
        <section id="grid">
            <h4>GRID</h4>
        </section>

        <section id="grid-basics">
            <h5>basics</h5>
            <!-- basic 2-column that breaks at medium  -->
            <div class="row show-grid">
                <div class="col-md-6">.col-md-6</div>
                <div class="col-md-6">.col-md-6</div>
            </div>
            <!-- Stack the columns on mobile by making one full-width and the other half-width -->
            <div class="row show-grid">
                <div class="col-xs-12 col-md-8">.col-xs-12 .col-md-8</div>
                <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
            </div>
            <!-- Columns start at 50% wide on mobile and bump up to 33.3% wide on desktop -->
            <div class="row show-grid">
                <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
                <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
                <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
            </div>
            <!-- Columns are always 50% wide, on mobile and desktop -->
            <div class="row show-grid">
                <div class="col-xs-6">.col-xs-6</div>
                <div class="col-xs-6">.col-xs-6</div>
            </div>
            </section>
            <section id="grid-clear">
                <h5>clear float for uneven columns</h5>
                <div class="row show-grid">
                    <div class="col-xs-6 col-sm-3">1) .col-xs-6 .col-sm-3<br>Resize your viewport or check it out on your phone for an example.</div>
                    <div class="col-xs-6 col-sm-3">2) .col-xs-6 .col-sm-3</div>
                    <!--    Add the extra clearfix for only the required viewport This  will force the following under the first column rather than floating to right of it  <div class="clearfix visible-xs"></div>-->
                    <div class="col-xs-6 col-sm-3">3) .col-xs-6 .col-sm-3</div>
                    <div class="col-xs-6 col-sm-3">4) .col-xs-6 .col-sm-3</div>
                </div>
            </section>
            <section id="grid-offset">
                <h5>offest columns</h5>
                <div class="row show-grid">
                    <div class="col-sm-5 col-md-6">.col-sm-5 .col-md-6</div>
                    <div class="col-sm-5 col-sm-offset-2 col-md-6 col-md-offset-0">.col-sm-5 .col-sm-offset-2 .col-md-6 .col-md-offset-0</div>
                </div>

                <div class="row show-grid">
                    <div class="col-sm-6 col-md-5 col-lg-6">.col-sm-6 .col-md-5 .col-lg-6</div>
                    <div class="col-sm-6 col-md-5 col-md-offset-2 col-lg-6 col-lg-offset-0">.col-sm-6 .col-md-5 .col-md-offset-2 .col-lg-6 .col-lg-offset-0</div>
                </div>
                <div class="row show-grid">
                    <div class="col-md-4">.col-md-4</div>
                    <div class="col-md-4 col-md-offset-4">.col-md-4 .col-md-offset-4</div>
                </div>
                <div class="row show-grid">
                    <div class="col-md-3 col-md-offset-3">.col-md-3 .col-md-offset-3</div>
                    <div class="col-md-3 col-md-offset-3">.col-md-3 .col-md-offset-3</div>
                </div>
                <div class="row show-grid">
                    <div class="col-md-6 col-md-offset-3">.col-md-6 .col-md-offset-3</div>
                </div>
            </section>
            <section id="grid-order" >
                <h5>ordering columns (push & pull)</h5>
                <div class="row show-grid">
                    <div class="col-md-9 col-md-push-3">1) .col-md-9 .col-md-push-3</div>
                    <div class="col-md-3 col-md-pull-9">2) .col-md-3 .col-md-pull-9</div>
                </div>
            </section>
            <section  id="grid-custom">
                <h5>customize with mixins: see source & frontend.less</h5>
                <div class="test-wrapper test-show-grid">
                    <div class="test-content-main">foo</div>
                    <div class="test-content-secondary">bar</div>
                </div>
            </section>
            <section  id="grid-breaks">
                <h5>hiding/showing divs at a breakpoint (see source)</h5>
                <div class="row show-grid">
                    <div class="col-md-4 hidden-xs">hide at xs</div>
                    <div class="col-md-4 visible-xs">visible at xs</div>
                    <div class="col-md-4">visible throughout</div>
                    <div class="col-md-4 visible-sm visible-lg">visible on lg or sm</div>
                </div>
            </section>
            <section  id="grid-print">
                <h5>hiding/showing divs for browser vs printing (see source)</h5>
                <div class="row show-grid">
                    <div class="col-md-4 hidden-print">hide for print only</div>
                    <div class="col-md-4 col-md-offset-4 visible-print">show for print only</div>
                </div>
            </section>

            <div><hr></div>

              {{-- ******************************** TYPOGRAPHY ********************************* --}}
            <section  id="type">
                <h4>TYPOGRAPHY</h4>
            </section>
            <section  id="type-basics">
                <h5>Basics</h5>
                <p>Typical paragraph is 14px</p>
                <p><small>This line of text is meant to be treated as fine print, using .small or <code>small</code></small></p>
                <p class="lead">A lead paragraph using .lead</p>
                <h3>Bootstrap heading <small>Secondary text using <code>small</code> within <code>h3</code></small></h3>
                <p>An abbreviation using <code>abbr</code> &amp; title attribute is <abbr title="HyperText Markup Language">HTML</abbr>.</p>
                <p>Add .initialism for a smaller abbreviation font size is <abbr title="HyperText Markup Language" class="initialism">HTML</abbr>.</p>
                <blockquote>
                    <p>Using <code>blockqoute</code> Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </blockquote>

                <ul class="list-unstyled">
                    <li>Using .list-unstyled</li>
                    <li>on the</li>
                    <li><code>ul</code> tag</li>
                </ul>
                <ul class="list-inline">
                    <li>Using .list-inline</li>
                    <li>on the</li>
                    <li><code>ul</code> tag</li>
                </ul>
                <dl class="dl-horizontal">
                    <dt>Description lists</dt>
                    <dd>Using .dl-horizontal on the <code>dl</code> tag</dd>
                    <dt>Euismod</dt>
                    <dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.</dd>
                </dl>
            </section>
            <section  id="type-contextual">
                <h5>Color contextual text &amp; background options</h5>
                <p class="text-muted">muted: Fusce dapibus, ullamcorper nulla tellus ac cursus commodo, tortor mauris nibh.</p>
                <p class="text-primary">primary: Nullam id  ullamcorper nulla dolor id nibh ultricies vehicula ut id elit.</p>
                <p class="text-success">success: Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p>
                <p class="text-info">info: Maecenas ullamcorper nulla sed diam eget risus varius blandit sit amet non magna.</p>
                <p class="text-warning">warning: Etiam porta sem malesuada magna mollis ullamcorper nulla euismod.</p>
                <p class="text-danger">danger: Donec ullamcorper nulla non metus auctor fringilla.</p>
                <br>
                <p style='padding:15px' class="bg-primary">Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                <p style='padding:15px' class="bg-success">Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p>
                <p style='padding:15px' class="bg-info">Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
                <p style='padding:15px' class="bg-warning">Etiam porta sem malesuada magna mollis euismod.</p>
                <p style='padding:15px' class="bg-danger">Donec ullamcorper nulla non metus auctor fringilla.</p>
            </section>
            <section  id="type-graphics">
                <h5>Close button, Caret</h5>
                <div class="row">
                    <div class="col-md-1"><button type="button" class="close" aria-hidden="true">&times;</button></div>
                    <div class="col-md-1"><span class="caret"></span></div>
                </div>
            </section>
            <section  id="type-alerts">
                <h5>Alerts</h5>
                <div class="alert alert-danger col-xs-12">
                    <strong>Alert!</strong> A basic alert, using the danger contextual class.
                </div>

                <div class="alert alert-warning alert-dismissable col-xs-12">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Warning!</strong> An alert you can dismiss. Set data-dismiss = alert
                </div>

                <div class="col-xs-12 alert alert-success alert-dismissable fade in">
                    <button data-dismiss="alert" aria-hidden="true" class="close" type="button">&times;</button>
                    Alert dismissal with fade out. Must use fade & in classes.
                </div>

                <div id="myAlert" class="col-xs-12 alert alert-success alert-dismissable fade">
                    <button data-dismiss="alert" aria-hidden="true" class="close" type="button">&times;</button>
                    Alert dismissal with fade in & out. Uses fade only, then adds 'in' class via JS, with timeout.
                </div>

                <div class="alert alert-danger alert-dismissable col-xs-12 fade in">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                    <h4>Oh snap! You got an error!</h4>
                    <p>Change this and that and try again. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
                    <p>
                        <button class="btn btn-danger" type="button">Take this action</button>
                        <button class="btn btn-default" type="button">Or do this</button>
                    </p>
                </div>
            </section>
            <div class="clearfix"></div>

            <div><hr></div>

            {{-- ******************************** TABLES ********************************* --}}
            <section  id="table">
                <h4>TABLES</h4>
            </section>
            <section  id="table-basics">
                <h5>Basics</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Use  <code>table class='table'</code> tag</td>
                            <td>Brown</td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Use  <code>table class='table table-striped'</code></td>
                            <td>Brown</td>
                        </tr>
                        <tr>
                            <td>FloJo</td>
                            <td>Mojo</td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Use  <code>table class="table table-hover"</code></td>
                            <td>Brown</td>
                        </tr>
                        <tr>
                            <td>FloJo</td>
                            <td>Mojo</td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Use  <code>table class="table table-bordered"</code></td>
                            <td>Brown</td>
                        </tr>
                        <tr>
                            <td>FloJo</td>
                            <td>Mojo</td>
                        </tr>
                    </tbody>
                </table>
            </section>
            <section  id="table-responsive">
                <h5>Wrap table in <code>div class="table-responsive"</code> &amp; it will scroll horizontal on xs devices</h5>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Table heading</th>
                                <th>Table heading</th>
                                <th>Table heading</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td class="success">Table cell</td>
                                <td>Table cell</td>
                                <td class="danger">Table cell</td>
                            </tr>
                            <tr class="active">
                                <td>2</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                                <td>Table cell</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
            <section  id="table-contextual">
                <h5>Row and cell contextual class colors</h5>

                <dl class="dl-horizontal">
                    <dt>.active</dt>
                    <dd>Applies the hover color to a particular row or cell</dd>
                    <dt>.success</dt>
                    <dd>Indicates a successful or positive action</dd>
                    <dt>.warning</dt>
                    <dd>Indicates a warning that might need attention</dd>
                    <dt>.danger</dt>
                    <dd>Indicates a dangerous or potentially negative action</dd>               
                </dl>
            </section>
            <div><hr></div>

            {{-- ******************************** FORMS ********************************* --}}
            <section  id="form">
                <h4>FORMS</h4>
            </section>
            <section  id="form-basics">
                <h5>Example form with many parts: form > Form Groups > label > input</h5>
                <form role="form">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">File input</label>
                        <input type="file" id="exampleInputFile">
                        <p class="help-block">Example block-level help text here.</p>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"> Check me out
                        </label>
                    </div>
                    <label class="checkbox-inline">
                        <input type="checkbox" id="inlineCheckbox1" value="option1"> inline
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" id="inlineCheckbox2" value="option2"> checkboxes
                    </label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                            Option one
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                            Option two
                        </label>
                    </div>
                    <div class="radio">
                        <label class="radio-inline">
                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                            Option one
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                            Option two
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </section>
            <section  id="form-horizontal">
                <h5>Horizontal Form: form-group is converted to .row, then use column divs</h5>
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Remember me
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Sign in</button>
                        </div>
                    </div>
                </form>
            </section>
            <section  id="form-static">
                <h5>Static control</h5>
                <form role="form" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">email@example.com</p>
                        </div>
                    </div>
                </form>
            </section>
                <section  id="form-types">
                    <h5>Input "type" options</h5>
                    <input type="text" class="form-control" placeholder="text input">
                    <input type="password" class="form-control" placeholder="password input">
                    <input type="" class="form-control" placeholder="supported types: datetime, date, month, time, week, number, email, url, search, tel">
                </section>
                <section  id="form-sizes">
                    <h5>Input size options, using .input-lg &amp; .input-sm</h5>
                    <input class="form-control input-lg" type="text" placeholder=".input-lg">
                    <input class="form-control" type="text" placeholder="Default input">
                    <input class="form-control input-sm" type="text" placeholder=".input-sm">
                </section>
                <section  id="form-columns">
                    <h5>Input column options, using grid row and columns</h5>
                    <div class="row">
                        <div class="col-xs-2">
                            <input type="text" class="form-control" placeholder=".col-xs-2">
                        </div>
                        <div class="col-xs-3">
                            <input type="text" class="form-control" placeholder=".col-xs-3">
                        </div>
                        <div class="col-xs-4">
                            <input type="text" class="form-control" placeholder=".col-xs-4">
                        </div>
                    </div>
                </section>
                <section  id="form-color">
                    <h5>Input color options (e.g. has-warning) and icons, using .has-feedback &amp; <code>span</code></h5>
                    <div class="form-group has-success has-feedback">
                        <label class="control-label" for="inputSuccess1">Input with success</label>
                        <input type="text" class="form-control" id="inputSuccess1">
                        <span class="glyphicon glyphicon-ok-sign form-control-feedback"></span>
                    </div>
                    <div class="form-group has-warning has-feedback">
                        <label for="inputWarning2" class="control-label">Input with warning</label>
                        <input type="text" id="inputWarning2" class="form-control">
                        <span class="glyphicon glyphicon-warning-sign form-control-feedback"></span>
                    </div>
                    <div class="form-group has-error has-feedback">
                        <label class="control-label" for="inputError1">Input with error</label>
                        <input type="text" class="form-control" id="inputError1">
                        <span class="glyphicon glyphicon-remove-sign form-control-feedback"></span>
                    </div>
                </section>
                <section  id="form-help">
                    <h5>Help text</h5>
                    <form role="form">
                        <input type="text" class="form-control">
                        <span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>
                    </form>
                </section>
                <section  id="form-groups">
                    <h5>Input Groups. note: all the fields are input fields</h5>
                    <div class="col-xs-2">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="form-control">
                            <span class="input-group-addon">.00</span>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <input type="checkbox">
                            </span>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="input-group">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </div>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="input-group">
                            <div class="input-group-btn">
                                <button tabindex="-1" class="btn btn-default" type="button">Action</button>
                                <button tabindex="-1" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul role="menu" class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </div>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </section>
                <div><hr></div>

                           {{-- ******************************** BUTTONS ********************************* --}}
                <section  id="button">
                    <h4>BUTTONS</h4>
                </section>
                <section  id="button-basics">
                    <h5>The .btn class can be used on <code>a</code>, <code>button</code>, and <code>input</code> tags. Note: don't mix href with button!</h5>

                    <a class="btn btn-default" href="#" role="button">Link</a>
                    <button class="btn btn-default" type="submit">Button</button>
                    <input class="btn btn-default" type="button" value="Input">
                    <input class="btn btn-default" type="submit" value="Submit">
                    <br><br>

                    <!-- Standard button -->
                    <button type="button" class="btn btn-default">Default</button>

                    <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
                    <button type="button" class="btn btn-primary">Primary</button>

                    <!-- Indicates a successful or positive action -->
                    <button type="button" class="btn btn-success">Success</button>

                    <!-- Contextual button for informational alert messages -->
                    <button type="button" class="btn btn-info">Info</button>

                    <!-- Indicates caution should be taken with this action -->
                    <button type="button" class="btn btn-warning">Warning</button>

                    <!-- Indicates a dangerous or potentially negative action -->
                    <button type="button" class="btn btn-danger">Danger</button>

                    <!-- Deemphasize a button by making it look like a link while maintaining button behavior -->
                    <button type="button" class="btn btn-link">Link-like Button</button>
                    <br><br>
                    <p>
                        <button type="button" class="btn btn-primary btn-lg">Large button</button>
                        <button type="button" class="btn btn-default btn-lg">Large button</button>
                    </p>
                    <p>
                        <button type="button" class="btn btn-primary">Default button</button>
                        <button type="button" class="btn btn-default">Default button</button>
                    </p>
                    <p>
                        <button type="button" class="btn btn-primary btn-sm">Small button</button>
                        <button type="button" class="btn btn-default btn-sm">Small button</button>
                    </p>
                    <p>
                        <button type="button" class="btn btn-primary btn-xs">Extra small button</button>
                        <button type="button" class="btn btn-default btn-xs">Extra small button</button>
                    </p>
                    <p><button type="button" class="btn btn-primary btn-lg btn-block">Block level button</button>
                        <button type="button" class="btn btn-default btn-lg btn-block">Block level button</button>
                    </p>
                </section>
                <section  id="button-loading">
                    <h5>Loading State, Checkbox & Radio buttons</h5>

                    <div class="row">
                        <div class="col-md-2">
                            <button type="button" id="loading-example-btn" data-loading-text="Loading..." class="btn btn-primary nofade">
                                Loading state
                            </button>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary nofade" data-toggle="button">Toggle Button</button>

                        </div>
                        <div class="col-md-4">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary nofade">
                                    <input type="checkbox"> Toggle 1
                                </label>
                                <label class="btn btn-primary nofade">
                                    <input type="checkbox"> Checkbox 2
                                </label>
                                <label class="btn btn-primary nofade">
                                    <input type="checkbox"> Buttons 3
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary nofade">
                                    <input type="radio" name="options" id="option1"> Toggle 1
                                </label>
                                <label class="btn btn-primary nofade">
                                    <input type="radio" name="options" id="option2"> Radio 2
                                </label>
                                <label class="btn btn-primary nofade">
                                    <input type="radio" name="options" id="option3"> Buttons 3
                                </label>
                            </div>
                        </div>
                    </div>
                </section>
                <section  id="button-active">
                    <h5>Forcing the .active class on buttons and links</h5>
                    <button type="button" class="btn btn-primary btn-lg active">Primary button</button>
                    <button type="button" class="btn btn-default btn-lg active">Button</button>
                    <a href="#" class="btn btn-primary btn-lg active" role="button">Primary link</a>
                    <a href="#" class="btn btn-default btn-lg active" role="button">Link</a>
                </section>
                <section  id="button-disable">
                    <h5>Disabling using the .disabled class on buttons and links (chokes on IE9)</h5>
                    <button type="button" class="btn btn-lg btn-primary" disabled="disabled">Primary button</button>
                    <button type="button" class="btn btn-default btn-lg" disabled="disabled">Button</button>
                    <a href="#" class="btn btn-primary btn-lg disabled" role="button">Primary link</a>
                    <a href="#" class="btn btn-default btn-lg disabled" role="button">Link</a>
                </section>
                <div><hr></div>
                {{-- ******************************** IMAGES ********************************* --}}
                <section  id="image">
                    <h4>IMAGES</h4>
                </section>
                <section  id="image-responsive">
                    <h5>Make images responsive to their parent element using .img-responsive</h5>
                    <div id="container">
                        <div class="row">
                            <div class="col-md-2">
                                <a class="thumbnail" href=""><img alt="" src="http://placehold.it/260x180/f4cab0"></a>
                            </div>
                        </div>
                    </div>

                    <img src="http://placehold.it/180x120/f4cab0&text=rounded" alt="..." class="img-rounded">
                    <img src="http://placehold.it/180x120/f4cab0&text=circle" alt="..." class="img-circle">
                    <img src="http://placehold.it/180x120/f4cab0&text=thumbnail" alt="..." class="img-thumbnail">
                </section>
                <div><hr></div>

      {{-- ******************************** MIXINS ********************************* --}}
                <section id="mixin">
                    <h4>MIXINS</h4>
                </section>
                <section id="mixin-fx">
                    <h5>Various FX</h5><br>
                    <div class="row">
                        <div class="col-xs-4">
                            <p class="testdiv2 test-round-top bg-info">Round top corners &amp; transition</p>
                        </div>
                        <div class="col-xs-4">
                            <p class="testdiv test-round-bottom bg-info">Round bottom corners &amp; translate</p>
                        </div>
                        <div class="col-xs-4">
                            <p class="testdiv test-round-left bg-info">Round left corners &amp; rotate</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-4">
                            <p class="testdiv test-gradient bg-info">Gradient</p>
                        </div>
                        <div class="col-xs-4">
                            <p class="testdiv test-shadow bg-info">Box shadow, opacity.</p>
                        </div>
                        <div class="col-xs-3">
                            <p class="testdiv test-rectangle bg-info">Sized rectangle</p>
                        </div>
                        <div class="col-xs-1">
                            <p class="testdiv test-square bg-info">Sized square</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-4">
                            <p class="testdiv test-resizable bg-info">This is some text that is resizeable in both directions.</p>
                        </div>
                        <div class="col-xs-4">
                            <p class="testdiv test-resizable-v bg-info">This is some text that is resizeable in vertical direction.</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-4">
                            <p class='testdiv bg-info test-truncate'>Some content that will get truncated at it's width.</p>
                        </div>
                        <div class="col-xs-8">
                            <p style='width:400px; padding:15px' class="bg-danger center-block">Center any content block in an element  with .center-block</p>
                        </div>
                    </div>
                </section>
                <section id="mixin-pull">
                    <h5>Float left and right using .pull-left &amp; .pull-right. Can be used as mixins on an element: .pull-right(), .pull-left()</h5>
                    <p><button class="btn btn-warning pull-left" type="button">Warning</button></p>
                    <p><button class="btn btn-danger pull-right" type="button">Danger</button></p>
                    <div class="clearfix"></div>
                </section>
                <section id="mixin-columns">
                    <h5>Create columns using content-columns() mixin</h5>
                    <div class='test-columns'>
                        This is some content divided into multiple columns using the content-columns() mixin. This is some content divided into multiple columns using the content-columns() mixin. This is some content divided into multiple columns using the content-columns() mixin. This is some content divided into multiple columns using the content-columns() mixin.
                    </div>
                </section>
                <div><hr></div>
        {{-- ******************************** COMPONENTS ********************************* --}}

        <section id="component">            
            <h4>COMPONENTS</h4>
        </section>
        <section id="component-glyphicon">
            <h5>Glyphicons</h5><br>
            <button type="button" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-star"></span> Star
            </button>
        </section>
        <section id="component-dropdown">
            <h5>Dropdown: with divider, header, disabled item, a required trigger link</h5><br>
            <div class="row">
                <div class="col-xs-2">
                    <div class="dropdown">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            Dropdown Link
                            <span class="caret"></span>
                        </a> 
                        <button data-toggle="dropdown" id="dropdownMenu1" type="button" class="btn dropdown-toggle sr-only">
                            Dropdown
                            <span class="caret"></span>
                        </button>
                        <ul aria-labelledby="dropdownMenu1" role="menu" class="dropdown-menu">
                            <li role="presentation" class="dropdown-header">Dropdown header</li>
                            <li role="presentation"><a href="#" tabindex="-1" role="menuitem">Action</a></li>
                            <li role="presentation"><a href="#" tabindex="-1" role="menuitem">Another action</a></li>
                            <li role="presentation" class="disabled"><a href="#" tabindex="-1" role="menuitem">A disabled action</a></li>
                            <li class="divider" role="presentation"></li>
                            <li role="presentation"><a href="#" tabindex="-1" role="menuitem">Separated link</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                            Dropdown Button <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger">Split Button</button>
                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="btn-group-vertical">
                        <button class="btn btn-default" type="button">Vertical</button>
                        <button class="btn btn-default" type="button">Dropdown</button>
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" id="btnGroupVerticalDrop1">
                                Dropdown
                                <span class="caret"></span>
                            </button>
                            <ul aria-labelledby="btnGroupVerticalDrop1" role="menu" class="dropdown-menu">
                                <li><a href="#">Dropdown link</a></li>
                                <li><a href="#">Dropdown link</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="component-buttongroup">
            <h5>Button Groups</h5><br>
            <div class="row">
                <div class="col-xs-3">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default">Left</button>
                        <button type="button" class="btn btn-default">Middle</button>
                        <button type="button" class="btn btn-default">Right</button>
                    </div>   
                </div>
                <div class="col-xs-3">
                    <div class="btn-group-sm">
                        <button type="button" class="btn btn-default">Left</button>
                        <button type="button" class="btn btn-default">Middle</button>
                        <button type="button" class="btn btn-default">Right</button>
                    </div>   
                </div>    
                <div class="col-xs-3">
                    <div style="margin: 0;" role="toolbar" class="btn-toolbar">
                        <div class="btn-group">
                            <button class="btn btn-default" type="button">1</button>
                            <button class="btn btn-default" type="button">2</button>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-default" type="button">3</button>
                            <button class="btn btn-default" type="button">4</button>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-default" type="button">5</button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default">1</button>
                        <button type="button" class="btn btn-default">2</button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                Dropdown
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Dropdown link</a></li>
                                <li><a href="#">Dropdown link</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="component-nav">
            <h5>Nav Tabs & Pills</h5><br>
            <div class="row">
                <div class="col-xs-4">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#">Home</a></li>
                        <li class="disabled"><a href="#">Disabled</a></li>
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                Dropdown <span class="caret"></span>
                            </a>
                            <ul role="menu" class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-3">
                    <ul class="nav nav-pills">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#">Prfle</a></li>
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                Drop <span class="caret"></span>
                            </a>
                            <ul role="menu" class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-2">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#">Profile</a></li>
                        <li><a href="#">Messages</a></li>
                    </ul>
                </div>
                <div class="col-xs-3">
                    <ul class="nav nav-tabs nav-justified">
                        <li class="active"><a href="#">Home</a></li>
                        <li class="disabled"><a href="#">Justified</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <section id="component-navbar">
            <h5>Navbar</h5><br>
            <div class="row">
                <div class="col-xs-12">
                    <nav role="navigation" class="navbar navbar-default">{{-- bounding nav tag --}}
                        <div class="container-fluid">{{-- bounding fluid container --}}
                            <div class="navbar-header">{{-- header contains the Brand & the collapsed nav toggle --}}
                                <button data-target="#example-navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a href="#" class="navbar-brand">Brand</a>
                            </div>
                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div id="example-navbar-collapse" class="collapse navbar-collapse">
                                <ul class="nav navbar-nav">
                                    <li class="active"><a href="#">Link</a></li>
                                    <li><a href="#">Link</a></li>
                                    <li class="dropdown">
                                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">Dropdown <b class="caret"></b></a>
                                        <ul role="menu" class="dropdown-menu">
                                            <li><a href="#">Action</a></li>
                                            <li><a href="#">Another action</a></li>
                                            <li><a href="#">Something else here</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#">Separated link</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#">One more separated link</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <form role="search" class="navbar-form navbar-left">
                                    <div class="form-group">
                                        <input type="text" placeholder="Search" class="form-control">
                                    </div>
                                    <button class="btn btn-default" type="submit">Submit</button>
                                </form>
                                <ul class="nav navbar-nav navbar-right">
                                    <li><a href="#">Link</a></li>
                                    <li class="dropdown">
                                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">Dropdown <b class="caret"></b></a>
                                        <ul role="menu" class="dropdown-menu">
                                            <li><a href="#">Action</a></li>
                                            <li><a href="#">Another action</a></li>
                                            <li><a href="#">Something else here</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#">Separated link</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div><!-- /.navbar-collapse -->
                        </div><!-- /.container-fluid -->
                    </nav><!-- /.bounding nav -->
                </div>
            </div>
        </section>
        <section id="component-element">
            <h5>Navbar Elements</h5><br>
            <nav role="navigation" class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button data-target="#bs-example-navbar-collapse-5" data-toggle="collapse" class="navbar-toggle" type="button">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="#" class="navbar-brand">Brand</a>
                    </div>
                    <p class="navbar-text">Some text</p>
                    <form role="search" class="navbar-form navbar-left">
                        <div class="form-group">
                            <label class="sr-only" for="search">Search</label>
                            <input type="text" placeholder="Search Form" id='search' class="form-control">
                        </div>
                        <button class="btn btn-default" type="submit">Submit</button>
                    </form>
                    <div id="bs-example-navbar-collapse-5" class="collapse navbar-collapse">
                        <p class="navbar-text navbar-right">A non-nav link <a class="navbar-link" href="#">MAC</a></p>
                    </div>
                </div>
            </nav>
        </section>
        <section id="component-label">
            <h5>Labels, Badges</h5><br>
            <div class="row">
                <div class="col-xs-3">
                    <h4>Example <span class="label label-primary">Label</span></h4>
                </div>
                <div class="col-xs-5">
                    <ul class="nav nav-pills">
                        <li class="active"><a href="#">Home <span class="badge">42</span></a></li>
                        <li><a href="#">Profile</a></li>
                        <li><a href="#">Messages <span class="badge">3</span></a></li>
                    </ul>
                </div>
            </div>
        </section>
        <section id="component-thumbnail">
            <h5>Thumbnails: works with responsive resizing to maintain grid of images, video, etc</h5><br>
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <img src="http://placehold.it/300x150/336699">
                        <div class="caption">
                            <h3>Thumbnail label</h3>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus.</p>
                            <p><a role="button" class="btn btn-primary" href="#">Button</a> <a role="button" class="btn btn-default" href="#">Button</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <img src="http://placehold.it/300x150/336699">
                        <div class="caption">
                            <h3>Thumbnail label</h3>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus.</p>
                            <p><a role="button" class="btn btn-primary" href="#">Button</a> <a role="button" class="btn btn-default" href="#">Button</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <img src="http://placehold.it/300x150/336699">
                        <div class="caption">
                            <h3>Thumbnail label</h3>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus.</p>
                            <p><a role="button" class="btn btn-primary" href="#">Button</a> <a role="button" class="btn btn-default" href="#">Button</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="component-media">
            <h5>Media Objects</h5><br>
            <div class="media">
                <a href="#" class="pull-left">
                    <img src="http://placehold.it/64/336699/fff">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">Basic</h4>
                    Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                </div>
            </div>

            <div class="media">
                <a href="#" class="pull-left">
                    <img src="http://placehold.it/64/336699/fff">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">Basic with &hellip;</h4>
                    Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                    <div class="media">
                        <a href="#" class="pull-left">
                            <img src="http://placehold.it/64/336699/fff">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">&hellip; nested Media</h4>
                            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-6 col-offeset-6 media">
                <a href="#" class="pull-right">
                    <img src="http://placehold.it/64/336699/fff">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">Media Flush Right</h4>
                    Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                </div>
            </div>

            <div class="clearfix"></div>
        </section>
        <section id="component-listgroup">
            <h5>List Groups</h5><br>
            <div class="row">
                <div class="col-xs-6">
                    <ul class="list-group">
                        <li class="list-group-item">Basic List Item</li>
                        <li class="list-group-item"><span class="badge">14</span>Item with Badge</li>
                        <li class="list-group-item list-group-item-danger">Contextual Item</li>
                        <li class="list-group-item  list-group-item-warning">Porta ac consectetur ac</li>
                    </ul>

                </div>
                <div class="col-xs-6">
                    <div class="list-group">
                        <a href="#" class="list-group-item">Basic Linking Item</a>
                        <a href="#" class="list-group-item list-group-item-success">Contextual Linked Item</a>
                        <a href="#" class="list-group-item active">
                            <h4 class="list-group-item-heading">Custom List Group Item Heading</h4>
                            <p class="list-group-item-text">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo.</p>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section id="component-panel">
            <h5>Panels</h5><br>
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            Basic panel example
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">Panel heading without title</div>
                        <div class="panel-body">
                            Panel content
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Panel title</h3>
                        </div>
                        <div class="panel-body">
                            Panel content
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            Panel content
                        </div>
                        <div class="panel-footer">Panel footer</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Panel title</h3>
                        </div>
                        <div class="panel-body">
                            Contextual content
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title">Panel title</h3>
                        </div>
                        <div class="panel-body">
                            Contextual content
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">Panel heading</div>
                        <div class="panel-body">
                            <p>This is a Panel with a Table inside! Note: this div disappears if no content.</p>
                        </div>
                        <!-- Table -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Username</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">Panel heading</div>
                        <div class="panel-body">
                            <p>This is a Panel with a List Group inside!</p>
                        </div>
                        <!-- List group -->
                        <ul class="list-group">
                            <li class="list-group-item">Cras justo odio</li>
                            <li class="list-group-item">Dapibus ac facilisis in</li>
                            <li class="list-group-item">Morbi leo risus</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section id="component-well">
            <h5>Wells</h5><br>
            <div class="row">
                <div class="col-xs-4">
                    <div class="well">Cras sit amet nibh libero, in gravida nulla.</div>
                </div>
                <div class="col-xs-4">
                    <div class="well well-sm">Cras sit amet nibh libero, in gravida nulla.</div>
                </div>
                <div class="col-xs-4">
                    <div class="well well-lg">Cras sit amet nibh libero, in gravida nulla.</div>
                </div>
            </div>
        </section>
        <div><hr></div>

        {{-- ******************************** CSS MISC ********************************* --}}
        <section id="css">
            <h4>CSS MISC & NOTES</h4>
            - always check component dependencies <br>
            <code>address tag</code><br>
            - disabling form fields or entire forms<br>
            - retina image handling<br>
            - use labels for all form inputs, even if .sr-only<br>
            - Tooltips & popovers in button groups require special setting (container: 'body')<br>
            - Button dropdowns require the dropdown plugin to be included in your version of Bootstrap.<br>
            - If JavaScript is disabled and the navbar collapses, it will be impossible to expand the navbar.<br>
            - Be sure to add a role="navigation" to every navbar to help with accessibility.<br>
            - Mobile Form caveats: http://getbootstrap.com/getting-started/#support-fixed-position-keyboards <br>
            - The fixed navbar will overlay your other content, unless you add padding to the top of the <code>body</code>.<br>
            .data-toggle is used to toggle the defined element
            .show, .hidden, & .invisible (maintain in flow) &amp; as mixins .show(), .hidden(), .invisible()<br>
            .sr-only or .sr-only() (screen readers only)<br>
            .text-hide or .text-hide() (hide an element's text and replace with bg image, which needs to be added)<br>
            .navbar-fixed-top<br>
            .navbar-inverse<br>
            .dropdown-menu-right, .dropdown-menu-left for dropdowns<br>
            - IE8 problems: striped rows, round corners, badges won't self collapse with no content<br>
            - IE9 and below: don't support disabled attribute on a <code>fieldset</code>, and not really on a <code>button</code>.<br>
        </section>
        <div><hr></div>

        {{-- ******************************** JAVASCRIPT ********************************* --}}
        <section id="js">
            <h4>JAVASCRIPT PLUGINS</h4>
        </section>
        <section id="js-modal">
            <h5>Modals</h5><br>
            <button data-target="#myModal" data-toggle="modal" class="btn btn-primary btn-lg">
                Launch demo modal
            </button>

            <button data-target="#myModalScroll" data-toggle="modal" class="btn btn-primary btn-lg">
                Launch demo modal with ScrollSpy (not working)
            </button>

            <!-- sample modal content -->
            <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Modal Heading</h4>
                        </div>
                        <div class="modal-body">
                            <h4>Text in a modal</h4>
                            <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p>

                            <h4>Popover in a modal</h4>
                            <p>This <a href="#" role="button" class="btn btn-default popover-test" title="A Title" data-content="And here's some amazing content.">button</a> should trigger a popover on click.</p>

                            <h4>Tooltips in a modal</h4>
                            <p><a href="#" class="tooltip-test" title="Tooltip">This link</a> and <a href="#" class="tooltip-test" title="Tooltip">that link</a> should have tooltips on hover.</p>
                            <hr>
                            <h4>Overflowing text to show scroll behavior</h4>
                            <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                            <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
                            <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!-- sample modal content -->
            <div id="myModalScroll" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="border-bottom:none;">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <nav role="navigation" class="navbar navbar-default navbar-static" id="navbar-example22">
                                <div class="container-fluid">
                                    <div class="navbar-header">
                                        <button data-target=".bs-example-js-navbar-scrollspy22" data-toggle="collapse" type="button" class="navbar-toggle">
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                        <a href="#" class="navbar-brand">Project Name</a>
                                    </div>
                                    <div class="collapse navbar-collapse bs-example-js-navbar-scrollspy22">
                                        <ul class="nav navbar-nav">
                                            <li class="active"><a href="#frog">Frog</a></li>
                                            <li class=""><a href="#lion">Lion</a></li>
                                            <li class="dropdown">
                                                <a data-toggle="dropdown" class="dropdown-toggle" id="navbarDrop22" href="#">Dropdown <b class="caret"></b></a>
                                                <ul aria-labelledby="navbarDrop22" role="menu" class="dropdown-menu">
                                                    <li class=""><a tabindex="-1" href="#xxx">xxx</a></li>
                                                    <li class=""><a tabindex="-1" href="#yyy">yyy</a></li>
                                                    <li class="divider"></li>
                                                    <li class=""><a tabindex="-1" href="#zzz">zzz</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <div class="test-scrollspy" data-offset="0" data-target="#navbar-example22" data-spy="scroll">
                                <h4 id="frog">frog</h4>
                                <p>Ad leggings keytar, brunch id art party dolor labore. Pitchfork yr enim lo-fi before they sold out qui. Tumblr farm-to-table bicycle rights whatever. Anim keffiyeh carles cardigan. Velit seitan mcsweeney's photo booth 3 wolf moon irure.</p>
                                <h4 id="lion">lion</h4>
                                <p>Veniam marfa mustache skateboard, adipisicing fugiat velit pitchfork beard.</p>
                                <h4 id="xxx">xxx</h4>
                                <p>Occaecat commodo aliqua delectus. Fap craft beer deserunt skateboard ea.</p>
                                <h4 id="yyy">yyy</h4>
                                <p>In incididunt echo park, officia deserunt mcsweeney's proident master cleanse thundercats sapiente veniam.</p>
                                <h4 id="zzz">zzz</h4>
                                <p>Ad leggings keytar, brunch id art party dolor labore. Pitchfork yr enim lo-fi before they sold out qui.</p>
                            </div>
                        </div><!-- /.modal-body -->
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </section>
        <section id="js-scroll">
            <h5>ScrollSpy & Togglable tabs</h5><br>
            <div class="row">
                <div class="col-md-6">
                    <nav role="navigation" class="navbar navbar-default navbar-static" id="navbar-example2">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button data-target=".bs-example-js-navbar-scrollspy" data-toggle="collapse" type="button" class="navbar-toggle">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a href="#" class="navbar-brand">Project Name</a>
                            </div>
                            <div class="collapse navbar-collapse bs-example-js-navbar-scrollspy">
                                <ul class="nav navbar-nav">
                                    <li class="active"><a href="#apple">Apple</a></li>
                                    <li class=""><a href="#orange">Orange</a></li>
                                    <li class="dropdown">
                                        <a data-toggle="dropdown" class="dropdown-toggle" id="navbarDrop1" href="#">Dropdown <b class="caret"></b></a>
                                        <ul aria-labelledby="navbarDrop1" role="menu" class="dropdown-menu">
                                            <li class=""><a tabindex="-1" href="#one">one</a></li>
                                            <li class=""><a tabindex="-1" href="#two">two</a></li>
                                            <li class="divider"></li>
                                            <li class=""><a tabindex="-1" href="#three">three</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <div class="test-scrollspy" data-offset="0" data-target="#navbar-example2" data-spy="scroll">
                        <h4 id="apple">apple</h4>
                        <p>Ad leggings keytar, brunch id art party dolor labore. Pitchfork yr enim lo-fi before they sold out qui. Tumblr farm-to-table bicycle rights whatever. Anim keffiyeh carles cardigan. Velit seitan mcsweeney's photo booth 3 wolf moon irure. Cosby sweater lomo jean shorts, williamsburg hoodie minim qui you probably haven't heard of them et cardigan trust fund culpa biodiesel wes anderson aesthetic. Nihil tattooed accusamus, cred irony biodiesel keffiyeh artisan ullamco consequat.</p>
                        <h4 id="orange">orange</h4>
                        <p>Veniam marfa mustache skateboard, adipisicing fugiat velit pitchfork beard. Freegan beard aliqua cupidatat mcsweeney's vero. Cupidatat four loko nisi, ea helvetica nulla carles. Tattooed cosby sweater food truck, mcsweeney's quis non freegan vinyl. Lo-fi wes anderson +1 sartorial. Carles non aesthetic exercitation quis gentrify. Brooklyn adipisicing craft beer vice keytar deserunt.</p>
                        <h4 id="one">one</h4>
                        <p>Occaecat commodo aliqua delectus. Fap craft beer deserunt skateboard ea. Lomo bicycle rights adipisicing banh mi, velit ea sunt next level locavore single-origin coffee in magna veniam. High life id vinyl, echo park consequat quis aliquip banh mi pitchfork. Vero VHS est adipisicing. Consectetur nisi DIY minim messenger bag. Cred ex in, sustainable delectus consectetur fanny pack iphone.</p>
                        <h4 id="two">two</h4>
                        <p>In incididunt echo park, officia deserunt mcsweeney's proident master cleanse thundercats sapiente veniam. Excepteur VHS elit, proident shoreditch +1 biodiesel laborum craft beer. Single-origin coffee wayfarers irure four loko, cupidatat terry richardson master cleanse. Assumenda you probably haven't heard of them art party fanny pack, tattooed nulla cardigan tempor ad. Proident wolf nesciunt sartorial keffiyeh eu banh mi sustainable. Elit wolf voluptate, lo-fi ea portland before they sold out four loko. Locavore enim nostrud mlkshk brooklyn nesciunt.</p>
                        <h4 id="three">three</h4>
                        <p>Ad leggings keytar, brunch id art party dolor labore. Pitchfork yr enim lo-fi before they sold out qui. Tumblr farm-to-table bicycle rights whatever. Anim keffiyeh carles cardigan. Velit seitan mcsweeney's photo booth 3 wolf moon irure. Cosby sweater lomo jean shorts, williamsburg hoodie minim qui you probably haven't heard of them et cardigan trust fund culpa biodiesel wes anderson aesthetic. Nihil tattooed accusamus, cred irony biodiesel keffiyeh artisan ullamco consequat.</p>
                        <p>Keytar twee blog, culpa messenger bag marfa whatever delectus food truck. Sapiente synth id assumenda. Locavore sed helvetica cliche irony, thundercats you probably haven't heard of them consequat hoodie gluten-free lo-fi fap aliquip. Labore elit placeat before they sold out, terry richardson proident brunch nesciunt quis cosby sweater pariatur keffiyeh ut helvetica artisan. Cardigan craft beer seitan readymade velit. VHS chambray laboris tempor veniam. Anim mollit minim commodo ullamco thundercats.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
                        <li><a data-toggle="tab" href="#profile">Profile</a></li>
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" id="myTabDrop1" href="#">Dropdown <b class="caret"></b></a>
                            <ul aria-labelledby="myTabDrop1" role="menu" class="dropdown-menu">
                                <li><a data-toggle="tab" tabindex="-1" href="#dropdown1">Apple</a></li>
                                <li><a data-toggle="tab" tabindex="-1" href="#dropdown2">Orange</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div id="home" class="tab-pane fade in active">
                            <p>Fade-able? ONE TAB MUST HAVE 'fade active in' classes. ALL OTHERS must have 'fade'.  Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
                        </div>
                        <div id="profile" class="tab-pane fade">
                            <p>Profile: Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
                        </div>
                        <div id="dropdown1" class="tab-pane fade">
                            <p>Apple: Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
                        </div>
                        <div id="dropdown2" class="tab-pane fade">
                            <p>Orange: Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.</p>
                        </div>
                    </div>
                </div>    
            </div>
        </section>
        <section id="js-tooltip">
            <h5>ToolTips (* must be initialized)</h5><br>
            <div class="row tooltip-test2">
                <div class="col-md-5">
                    Tight pants next level keffiyeh <a title="" data-toggle="tooltip" data-original-title="Default tooltip">you probably</a> haven't heard of them. Photo booth beard raw denim letterpress vegan messenger bag stumptown. Farm-to-table seitan, mcsweeney's fixie sustainable quinoa 8-bit american apparel <a title="" data-toggle="tooltip" href="#" data-original-title="Another tooltip">have a</a> terry richardson vinyl chambray.
                </div>
                <div class="col-md-7">
                    <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Tooltip on left">Tooltip on left</button>
                    <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Tooltip on top">Tooltip on top</button>
                    <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom">Tooltip on bottom</button>
                    <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Tooltip on right">Tooltip on right</button>
                </div>
            </div>
        </section>
        <section id="js-popover">
            <h5>Popovers (* must be initialized)</h5><br>
            <div class="row popover-test2">
                <div class="col-md-4">
                    Tight pants next level keffiyeh <a href="#" class="btn btn-default" role="button" title="A Title" data-content="And here's some amazing content.">you probably</a> haven't heard of them.
                </div>
                <div class="col-md-2">
                    <a href="#" role="button" class="btn btn-lg btn-danger" title="A Title" data-content="And here's some amazing content.">Click</a>
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">Popover left</button>
                    <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">Popover top</button>
                    <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Vivamus
                    sagittis lacus vel augue laoreet rutrum faucibus.">Popover bottom</button>

                </div>
            </div>
        </section>
        <section id="js-collapse">
            <h5>Collapsible</h5><br>
            <div id="accordion" class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#collapseOne" data-parent="#accordion" data-toggle="collapse" class="collapsed">
                                Collapsible Group Item #1
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse" id="collapseOne" style="height: 0px;">
                        <div class="panel-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#collapseTwo" data-parent="#accordion" data-toggle="collapse" class="collapsed">
                                Collapsible Group Item #2
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse" id="collapseTwo">
                        <div class="panel-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#collapseThree" data-parent="#accordion" data-toggle="collapse" class="collapsed">
                                Collapsible Group Item #3
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse" id="collapseThree">
                        <div class="panel-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div><hr></div>
        <section id='js-carousel'>
            <h5>Carousel (with captions)</h5><br>

            <div data-ride="carousel" class="carousel slide" id="test-carousel">
                {{-- INDICATORS *** one must start as 'active' *** --}}
                <ol class="carousel-indicators">
                    <li class="active" data-slide-to="0" data-target="#test-carousel"></li>
                    <li data-slide-to="1" data-target="#test-carousel" class=""></li>
                    <li data-slide-to="2" data-target="#test-carousel" class=""></li>
                </ol>
                {{-- SLIDES WRAPPER --}}
                <div class="carousel-inner">
                    {{-- SLIDE *** one must start as 'active' ***--}}
                    <div class="item active">
                      <img alt="First slide" src="http://placehold.it/900x500/996633">
                      {{-- CAPTION --}}
                        <div class="carousel-caption">
                            <h3>First slide label</h3>
                            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                        </div>
                    </div>
                    <div class="item">
                      <img alt="First slide" src="http://placehold.it/900x500/996633">
                      <div class="carousel-caption">
                            <h3>Second slide label</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                    <div class="item">
                      <img alt="First slide" src="http://placehold.it/900x500/996633">
                      <div class="carousel-caption">
                            <h3>Third slide label</h3>
                            <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                        </div>
                    </div>
                  </div>

                {{-- PREV/NEXT CONTROLS --}}
                <a data-slide="prev" href="#test-carousel" class="left carousel-control">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a data-slide="next" href="#test-carousel" class="right carousel-control">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </div>
        </section>

        <div><hr></div>
        <section id='js-affix'>
            <h5>Affix</h5><br>
            <p>See sidebar implementation</p>
        </section>
        <div><hr></div>

        {{-- ******************************** JS MISC ********************************* --}}
        <section id='js-notes'>
            <h4>JS MISC & NOTES</h4>
            - always check plugin dependencies <br>
            - Mobile Mobile caveats: http://getbootstrap.com/getting-started/#support-fixed-position-keyboards <br>
            - Toggable tabs fade: all must have 'fade' class, and one must start with 'active' & 'in'
        </section>
    </div>
    <div class="col-md-2">
        {{-- nav will proceed thru 3 positions, associated with 3 affix classes:
        affix-top:      static positioning; scrolls with window for first X pixels
        typically, add 10px to header height, but in this example we have 
        a fixed nav + no header we want to scroll off, so 0px is set
        affix:          fixed positioning; does not move within window for duration
        affix-bottom:   absolute positioning to the body; tellsnave when to jump
        to the last item in its list based on the footer height, plus 
        a little extra; requires body position is relative
        note: when using a fixed nav, the anchor position can be best set by wrapping in a
        section padded for the height of the header, like so
        .section {padding-top: 20px; margin-top: -20px;}
        --}}
        <div role="complementary" class="test-sidebar hidden-print" data-spy="affix" data-offset-top="0" data-offset-bottom="70">
            <ul class="nav test-sidenav">
                <li>
                    <a href="#grid">Grid</a>
                    <ul class="nav">
                        <li><a href="#grid-basics">Basics</a></li>
                        <li><a href="#grid-clear">Clear float</a></li>
                        <li><a href="#grid-offset">Offset columns</a></li>
                        <li><a href="#grid-order">Order columns</a></li>
                        <li><a href="#grid-custom">Customize mixins</a></li>
                        <li><a href="#grid-breaks">Hide/show - breaks</a></li>
                        <li><a href="#grid-print">Hide/show - print</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#type">Typography</a>
                    <ul class="nav">
                        <li><a href="#type-basics">Basics</a></li>
                        <li><a href="#type-contextual">Contextual text</a></li>
                        <li><a href="#type-graphics">Close, Carets</a></li>
                        <li><a href="#type-alerts">Alerts</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#table">Tables</a>
                    <ul class="nav">
                        <li><a href="#table-basics">Basics</a></li>
                        <li><a href="#table-responsive">Responsive Tables</a></li>
                        <li><a href="#table-contextual">Contextual rows/cells</a></li>
                    </ul>
                </li>  
                <li>
                    <a href="#form">Forms</a>
                    <ul class="nav">
                        <li><a href="#form-basics">Basics</a></li>
                        <li><a href="#form-horizontal">Horizontal</a></li>
                        <li><a href="#form-static">Static control</a></li>
                        <li><a href="#form-types">Input types</a></li>
                        <li><a href="#form-sizes">Input sizes</a></li>
                        <li><a href="#form-columns">Input columns</a></li>
                        <li><a href="#form-help">Help text</a></li>
                        <li><a href="#form-color">Input color</a></li>
                        <li><a href="#form-groups">Input groups</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#button">Buttons</a>
                    <ul class="nav">
                        <li><a href="#button-basics">Basics</a></li>
                        <li><a href="#button-loading">Loading, Check, Radio</a></li>
                        <li><a href="#button-active">Force active</a></li>
                        <li><a href="#button-disable">Disable</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#image">Images</a>
                    <ul class="nav">
                        <li><a href="#image-responsive">Responsive</a></li>
                    </ul>
                </li> 
                <li>
                    <a href="#mixin">Mixins</a>
                    <ul class="nav">
                        <li><a href="#mixin-fx">Various FX</a></li>
                        <li><a href="#mixin-pull">Float using pull</a></li>
                        <li><a href="#mixin-columns">Creating columns</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#component">Components</a>
                    <ul class="nav">
                        <li><a href="#component-glyphicon">Glyphicons</a></li>
                        <li><a href="#component-dropdown">Dropdowns</a></li>
                        <li><a href="#component-buttongroup">Button Groups</a></li>
                        <li><a href="#component-nav">Nav tabs &amp; pills</a></li>
                        <li><a href="#component-navbar">Navbar</a></li>
                        <li><a href="#component-element">Navbar elements</a></li>
                        <li><a href="#component-label">Labels &amp; badges</a></li>
                        <li><a href="#component-thumbnail">Thumbnails</a></li>
                        <li><a href="#component-media">Media objects</a></li>
                        <li><a href="#component-listgroup">List groups</a></li>
                        <li><a href="#component-panel">Panels</a></li>
                        <li><a href="#component-well">Wells</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#css">CSS Notes</a>
                </li>
                <li>
                    <a href="#js">JS Plugins</a>
                    <ul class="nav">
                        <li><a href="#js-modal">Modals</a></li>
                        <li><a href="#js-scroll">ScrollSpy &amp; Toggable Tabs</a></li>
                        <li><a href="#js-tooltip">Tooltips</a></li>
                        <li><a href="#js-popover">Popovers</a></li>
                        <li><a href="#js-collapse">Collapsible</a></li>
                        <li><a href="#js-carousel">Carousel</a></li>
                        <li><a href="#js-affix">Affix</a></li>
                    </ul>
                </li> 
                <li>
                    <a href="#js-notes">JS Notes</a>
                </li>                                            
            </ul>
            <a href="#top" class="back-to-top">
                Back to top
            </a>
        </div>
    </div>
</div>
@stop
