import Swal from 'sweetalert2';

export function useFlash() {

    const confirmFlash = (option) => {

        const {
            entity = "item",
            entityId,
            deleteAction,
            entityList,
            successMessage = "Your item has been deleted.",
            errorMessage = "Error on deleting the item."

        } = option;
        Swal.fire({
            title: `Are you sure you want to delete this ${entity}?`,
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                deleteAction(entityId)
                    .then(() => {
                        entityList.value = entityList.value.filter(item => item.id !== entityId);
                        Swal.fire({
                            title: "Deleted!",
                            text: successMessage,
                            icon: "success"
                        });
                    })
                    .catch(error => {
                        console.error(errorMessage, error);
                    });
            }
        });
    }

    const flash = (option) => {
        const {
            position = "center",
            title =  "Your work has been saved",
            timer = 1500,
            icon = "success"    
        } = option;

        Swal.fire({
            position: position,
            icon: icon,
            title: title,
            timer: timer
          });
    }
    return { confirmFlash, flash }
}