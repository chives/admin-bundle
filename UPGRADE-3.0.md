# UPGRADE FROM VERSION 2.1 TO 3.0

## Replace deprecated services and parameters IDs for ResourceRepository and Display

Deprecations marked in [2.1](CHANGELOG-2.1.md#deprecated-inconsintent-service-definitions-and-parameters-for-resourcerepository-and-display-contexts)
are removed, so if you used the old IDs and parameters, you need to change them to
the new ones.

## Pass event dispatcher to controllers' constructor

If you were using the `admin.event_dispatcher_aware` tag in order to inject the
event dispatcher into your services, you will need to change your service definition,
since the relevant compiler pass was removed.