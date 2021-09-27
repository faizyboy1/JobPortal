function ajaxCall() {
  this.send = function(data, url, method, success, type) {
    type = type || 'json'
    var successRes = function(data) {
      success(data)
    }

    var errorRes = function(e) {
      alert(
        'Error found \nError Code: ' +
          e.status +
          ' \nError Message: ' +
          e.statusText
      )
    }
    $.easyAjax({
      url: url,
      type: method,
      data: data,
      success: successRes,
      error: errorRes,
      dataType: type,
      timeout: 60000
    })
  }
}

function locationInfo() {
  var rootUrl = fetchCountryState
  var call = new ajaxCall()

  this.getStates = function(id) {
    $('.states option:gt(0)').remove()
    $('#stateId').val(0)
    $('#stateId').trigger('change')
    var url = rootUrl + '?type=getStates&countryId=' + id
    var method = 'post'
    var data = { _token: csrfToken }
    $('.states')
      .find('option:eq(0)')
      .html(pleaseWait)
    call.send(data, url, method, function(data) {
      $('.states')
        .find('option:eq(0)')
        .html(selectState)
      if (data.tp == 1) {
        $.each(data['result'], function(key, val) {
          var option = $('<option />')
          option.attr('value', key).text(val)
          $('.states').append(option)
          if (state == val) {
            $('#stateId').val(key)
            $('#stateId').trigger('change')
          }
        })
        state = ''
        $('.states').prop('disabled', false)
      } else {
        alert(data.msg)
      }
    })
  }

  this.getCountries = function() {
    var url = rootUrl + '?type=getCountries'
    var method = 'post'
    var data = { _token: csrfToken }

    $('.countries')
      .find('option:eq(0)')
      .html(pleaseWait)
    call.send(data, url, method, function(data) {
      $('.countries')
        .find('option:eq(0)')
        .html(selectCountry)

      if (data.tp == 1) {
        $.each(data['result'], function(key, val) {
          var option = $('<option />')
          option.attr('value', key).text(val)
          $('.countries').append(option)
          if (country == val) {
            $('#countryId').val(key)
            $('#countryId').trigger('change')
          }
        })
        country = ''
        $('.countries').prop('disabled', false)
      } else {
        alert(data.msg)
      }
    })
  }
}

$(function() {
  var loc = new locationInfo()
  loc.getCountries()
  $('body').on('change', '.countries', function(ev) {
    var countryId = $(this).val()
    if (countryId != '0') {
      loc.getStates(countryId)
    } else {
      $('.states option:gt(0)').remove()
      $('.cities option:gt(0)').remove()
      $('#stateId').val(0)
      $('#stateId').trigger('change')
      $('#cityId').val(0)
      $('#cityId').trigger('change')
    }
  })
})
